<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;
use App\RepliesLikeUnlike;

class RepliesController extends Controller
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
        $reply = new Reply;

        $reply->user_id = auth()->id();
        $reply->review_id = $request['rev_id'];
        $reply->content = $request['reply'];

        $reply->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
    }

    public function like(Request $request, Reply $reply)
    {  
        $impression = new RepliesLikeUnlike;

        $impression->user_id = auth()->id();
        $impression->reply_id = $reply->id;
        $impression->type = 1;
        //delete record if unlike exists
        $check_like = $impression->where('user_id', $impression->user_id)->where('reply_id', $impression->reply_id)->first();

        if($check_like) {
            $check_like->delete();
        }

        return json_encode($impression->save());

    }

    public function unlike(Request $request, Reply $reply)
    {
        $impression = new RepliesLikeUnlike;

        $impression->user_id = auth()->id();
        $impression->reply_id = $reply->id;
        $impression->type = 0;
        //delete record if like exists
        $check_like = $impression->where('user_id', $impression->user_id)->where('reply_id', $impression->reply_id)->first();

        if($check_like) {
            $check_like->delete();
        }

        return json_encode($impression->save());

    }
}
