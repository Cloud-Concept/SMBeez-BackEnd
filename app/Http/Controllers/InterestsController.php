<?php

namespace App\Http\Controllers;

use App\Interest;
use App\Project;
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
