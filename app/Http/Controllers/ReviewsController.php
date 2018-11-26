<?php

namespace App\Http\Controllers;

use App\Review;
use App\Company;
use App\ReviewsLikeUnlike;
use App\ReviewFlags;
use Illuminate\Http\Request;
use \App\Repositories\SMBeezFunctions;
use Mail;
use App\Mail\ReviewSubmitted;
use App\Mail\ReviewSubmittedOwner;

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
        $company = new Company;

        $review->reviewer_relation = 'customer';

        if(!$request['company_id']) {
            if($company->exist('company_name', $request['company_name'])) {
                //get the slug
                $slug = $company->where('company_name', $request['company_name'])->first();
                //go to claim this company page
                $review->company_id = $slug->id;
            } 
        }else{
            $review->company_id = $request['company_id'];
        }
             
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

        //relevance scoring
        $company = Company::with('reviews')->where('id', $review->company_id)->first();
        $customer_reviews = $company->reviews->where('company_id', $review->company_id)
        ->where('reviewer_relation', 'customer');

        if($customer_reviews->count() == 1) {
            Company::addRelevanceScore(5, $review->company_id);
        }

        if($company->company_overall_exact_rating($review->company_id) >= 4.5) {
            Company::addRelevanceScore(5, $review->company_id);
        }
        //mail to submitter
        Mail::to($review->user->email)->send(new ReviewSubmitted($review));
        //mail to company owner
        Mail::to($company->user->email)->send(new ReviewSubmittedOwner($review));

        $do = new SMBeezFunctions;
        $do->email_log($review->user->id, $review->user->email);

        //track CSM company
        $user = auth()->user();
        $track = new SMBeezFunctions;
        if($user->company->hasManager()) {
          $track->csm_company($user->company->manager_id, $user->company->id, 'submit_customer_review');
        }

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
        $company = new Company;

        $review->reviewer_relation = 'supplier';
        if(!$request['company_id']) {
            if($company->exist('company_name', $request['company_name'])) {
                //get the slug
                $slug = $company->where('company_name', $request['company_name'])->first();
                //go to claim this company page
                $review->company_id = $slug->id;
            } 
        }else{
            $review->company_id = $request['company_id'];
        }
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
        //relevance scoring
        $company = Company::with('reviews')->where('id', $review->company_id)->first();
        $suppliers_reviews = $company->reviews->where('company_id', $review->company_id)
        ->where('reviewer_relation', 'supplier');

        if($suppliers_reviews->count() == 1) {
            Company::addRelevanceScore(5, $review->company_id);
        }

        if($company->company_overall_exact_rating($review->company_id) >= 4.5) {
            Company::addRelevanceScore(5, $review->company_id);
        }
        //mail to submitter
        Mail::to($review->user->email)->send(new ReviewSubmitted($review));
        //mail to company owner
        Mail::to($company->user->email)->send(new ReviewSubmittedOwner($review));
        
        $do = new SMBeezFunctions;
        $do->email_log($review->user->id, $review->user->email);
        
        //track CSM company
        $user = auth()->user();
        $track = new SMBeezFunctions;
        if($user->company->hasManager()) {
          $track->csm_company($user->company->manager_id, $user->company->id, 'submit_supplier_review');
        }

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

        return json_encode($impression->save());

        //return back();
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

        return json_encode($impression->save());

        //return back();
    }

    public function flag(Request $request, Review $review)
    {   
        $flag = new ReviewFlags;

        $flag->user_id = auth()->id();
        $flag->review_id = $review->id;
        $flag->company_id = $review->company->id;

        return json_encode($flag->save());

        //return back();
    }

    public function unflag(Request $request, Review $review)
    {   
        $flag = new ReviewFlags;

        $flag = $flag->where('user_id', auth()->id())->where('review_id', $review->id)->first();

        return json_encode($flag->delete());

        //return back();
    }

}
