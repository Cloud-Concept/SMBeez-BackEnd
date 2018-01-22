<?php

namespace App\Http\Controllers;

use App\Interest;
use App\Project;
use App\Message;
use Illuminate\Http\Request;

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

        $interest->save();

        $message = new Message;
        $user = auth()->user();
        $user_company = route('front.company.show', $user->company->slug);
        $project_url = route('front.project.show', $interest->project->slug);
        $subject = $user->name . ' from <a href='.$user_company.'>' . $user->company->company_name . '</a> expressed interest on your project <a href='.$project_url.'>' . $interest->project->project_title . '</a>';
        
        $message_content = '<div class="btn-list mt-3 mb-4">
        <h5 class="mb-2">What is Express Interest</h5>
        <p>some designer watches. A watch is a piece of jewelry that you can wear every day, and it pretty much, will go with anything you are wearing. It’s not always going to make you look dressed up, but it may help you look more stylish,
        and sometimes that is all you want. Watches are the perfect answer to what you can wear with anything, because we are living in a world that always has to go through what time it is.
        There are a lot of different designer watches in the stoes. Some cost a lot than others. Though, you do not have to have a too costly watch to make yourself look good. Sometimes just owning a standard,
        everyday watch is another way to get the look you are going for</p>
        <h5 class="mb-2 mt-4">What else would you like to do? ...</h5>
        <div class="btn-list mt-3 mb-4"><a href="'.$user_company.'" class="btn btn-sm btn-yellow-2 mr-3">View Supplier Info</a> <a href="'.$project_url.'" class="btn btn-sm btn-blue btn-yellow">Update Project Details</a></div>';

        $message->message = $message_content;
        $message->subject = $subject;
        $message->sender_id = $interest->user_id;
        $message->user_id = $interest->project->user->id;
        $message->interest_id = $interest->id;
        
        $message->save();


        session()->flash('success', 'Thanks for expressing interest on that project.');

        return back();
    }

    public function accept_interest(Request $request, Interest $interest)
    {   
        
        $interest->where('id', $interest->id)->update(['is_accepted' => 1]);

        //$interest->project->where('id', $interest->project->id)->update(['status' => 'closed', 'status_on_close' => 'awarded', 'awarded_to' => $interest->user->id]);

        return back();
    }

    public function decline_interest(Request $request, Interest $interest)
    {   
        
        $interest->where('id', $interest->id)->update(['is_accepted' => 0]);

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
