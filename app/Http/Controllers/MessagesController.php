<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Session;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        $user = auth()->user();

        $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->paginate(10);

        return view('front.users.messages', compact('user', 'user_messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $id)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        
        $user = auth()->user();

        $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->paginate(15);

        if($id->user_id === $user->id) {
            return view('front.users.show-message', compact('id', 'user', 'user_messages'));
        }else {
            return redirect(route('front.messages.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
