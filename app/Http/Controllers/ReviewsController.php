<?php

namespace App\Http\Controllers;

use App\Review;
use App\Company;
use App\ReviewsLikeUnlike;
use App\ReviewFlags;
use Illuminate\Http\Request;

use Mail;
use App\Mail\ReviewSubmitted;

class ReviewsController extends Controller
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
    public function store_customer_review(Request $request)
    {
        $review = new Review;

        $review->reviewer_relation = 'customer';
        $review->company_id = $request['company_id'];
        $review->user_id = auth()->id();
        $review->feedback = $request['feedback'];
        $review->overall_rate = $request['overall_rate'];
        $review->business_repeat = $request['business_repeat'];
        $review->is_hired = $request['is_hired'];
        $review->review_privacy = $request['privacy'];

        $review->completness = $request['completness'];
        $review->why_not = $request['why_not'];
        $review->why_not_msg = $request['why_not_msg'];
        $review->quality = $request['quality'];
        $review->cost = $request['cost'];
        $review->time = $request['time'];
        

        $review->save();

        Mail::to($review->user->email)->send(new ReviewSubmitted($review));

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_supplier_review(Request $request)
    {
        $review = new Review;

        $review->reviewer_relation = 'supplier';
        $review->company_id = $request['company_id'];
        $review->user_id = auth()->id();
        $review->feedback = $request['feedback'];
        $review->overall_rate = $request['overall_rate'];
        $review->business_repeat = $request['business_repeat'];
        $review->is_hired = $request['is_hired'];
        $review->review_privacy = $request['privacy'];

        $review->completness = $request['completness'];
        $review->why_not = $request['why_not'];
        $review->why_not_msg = $request['why_not_msg'];
        $review->payments = $request['payments'];
        $review->expectations = $request['expectations'];
        $review->procurement = $request['procurement'];

        $review->save();

        Mail::to($review->user->email)->send(new ReviewSubmitted($review));
        
        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }


    public function like(Request $request, Review $review)
    {   
        $impression = new ReviewsLikeUnlike;

        $impression->user_id = auth()->id();
        $impression->review_id = $review->id;
        $impression->company_id = $review->company->id;
        $impression->type = 1;
        //delete record if unlike exists
        $check_like = $impression->where('user_id', $impression->user_id)->where('review_id', $impression->review_id)->first();

        if($check_like) {
            $check_like->delete();
        }

        $impression->save();

        return back();
    }

    public function unlike(Request $request, Review $review)
    {
        $impression = new ReviewsLikeUnlike;

        $impression->user_id = auth()->id();
        $impression->review_id = $review->id;
        $impression->company_id = $review->company->id;
        $impression->type = 0;
        //delete record if like exists
        $check_like = $impression->where('user_id', $impression->user_id)->where('review_id', $impression->review_id)->first();

        if($check_like) {
            $check_like->delete();
        }

        $impression->save();

        return back();
    }

    public function flag(Request $request, Review $review)
    {   
        $flag = new ReviewFlags;

        $flag->user_id = auth()->id();
        $flag->review_id = $review->id;
        $flag->company_id = $review->company->id;

        $flag->save();

        return back();
    }

    public function unflag(Request $request, Review $review)
    {   
        $flag = new ReviewFlags;

        $flag = $flag->where('user_id', auth()->id())->where('review_id', $review->id)->first();

        $flag->delete();

        return back();
    }

}
