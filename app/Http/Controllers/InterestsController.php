<?php

namespace App\Http\Controllers;

use App\Interest;
use App\Project;
use App\Message;
use Illuminate\Http\Request;
use \App\Repositories\SMBeezFunctions;
use Mail;
use App\Mail\SupplierAccepted;
use App\Mail\SupplierRejected;
use App\Mail\InterestedSupplier;
use Session;

class InterestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $interest = new Interest;

        $interest->user_id = auth()->id();
        $interest->project_id = $request['project_id'];

        //no. of express interests
        $project = Project::where('id', $interest->project_id)->first();
        
        if($project->interests->count() == 2) {
            $project->addRelevanceScore(5, $project->id);
        }

        if($project->interests->count() == 11) {
            $project->addRelevanceScore(15, $project->id);
        }

        $interest->save();

        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        $message = new Message;
        $user = auth()->user();
        $user_company = route('front.company.show', $user->company->slug);
        $project_url = route('front.project.show', $interest->project->slug);
        //$subject = $user->first_name . ' from <a href='.$user_company.' target="_blank">' . $user->company->company_name . '</a> expressed interest on your project <a href='.$project_url.' target="_blank">' . $interest->project->project_title . '</a>';
        $subject = sprintf(__('general.interest_subject'),$user->first_name,$user_company,$user->company->company_name,$project_url,$interest->project->project_title);
        
        $message_content = '<div class="btn-list mt-3 mb-4">
        <h5 class="mb-2 mt-4">What else would you like to do? ...</h5>
        <div class="btn-list mt-3 mb-4"><a href="'.$user_company.'" target="_blank" class="btn btn-sm btn-yellow-2 mr-3">View Supplier Info</a></div>';

        $message->message = $message_content;
        $message->subject = $subject;
        $message->sender_id = $interest->user_id;
        $message->user_id = $interest->project->user->id;
        $message->interest_id = $interest->id;
        
        $message->save();

        Mail::to($project->user->email)->send(new InterestedSupplier($project));

        $do = new SMBeezFunctions;
        $do->email_log($message->sender_id, $project->user->email);

        //track CSM company
        $track = new SMBeezFunctions;
        if($user->company->hasManager()) {
          $track->csm_company($user->company->manager_id, $user->company->id, 'express_interest');
        }

        session()->flash('success', 'Thanks for expressing interest on that project.');

        return back();
    }

    public function accept_interest(Request $request, Interest $interest)
    {   
        
        $interest->where('id', $interest->id)->update(['is_accepted' => 1]);

        //$interest->project->where('id', $interest->project->id)->update(['status' => 'closed', 'status_on_close' => 'awarded', 'awarded_to' => $interest->user->id]);
        Mail::to($interest->user->email)->send(new SupplierAccepted($interest));

        $do = new SMBeezFunctions;
        $do->email_log($interest->user->id, $interest->user->email);

        //track CSM company
        $user = auth()->user();
        $track = new SMBeezFunctions;
        if($user->company->hasManager()) {
          $track->csm_company($user->company->manager_id, $user->company->id, 'accept_interest');
        }

        return back();
    }

    public function decline_interest(Request $request, Interest $interest)
    {   
        
        $interest->where('id', $interest->id)->update(['is_accepted' => 0]);

        Mail::to($interest->user->email)->send(new SupplierRejected($interest));

        $do = new SMBeezFunctions;
        $do->email_log($interest->user->id, $interest->user->email);

        //track CSM company
        $user = auth()->user();
        $track = new SMBeezFunctions;
        if($user->company->hasManager()) {
          $track->csm_company($user->company->manager_id, $user->company->id, 'decline_interest');
        }

        return back();
    }

    public function undo_interest(Interest $interest)
    {   
        
        $interest->where('id', $interest->id)->update(['is_accepted' => null]);

        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function show(Interest $interest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interest $interest)
    {
        $interest->delete();

        session()->flash('success', 'You have withdrawn your interest.');

        return back();
    }
}
