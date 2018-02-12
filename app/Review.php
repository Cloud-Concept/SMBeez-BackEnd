<?php

namespace App;
use App\ReviewsLikeUnlike;
use App\ReviewFlags;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //company relationship
    public function company() {
        return $this->belongsTo(Company::class);
    }
    //user relationship
    public function user() {
        return $this->belongsTo(User::class);
    }
    //Likes & Unlikes
    public function likes() {
        return $this->hasMany(ReviewsLikeUnlike::class);
    }

    public function flags() {
        return $this->hasMany(ReviewFlags::class);
    }

    //Review Impression Like or Unlike
    public function impression($review_id)
    {   
        $check_like = ReviewsLikeUnlike::where('user_id', auth()->id())->where('review_id', $review_id)->first();

        if($check_like) {
            return $check_like->type;
        }else {
            return '';
        }
    }

    public function is_flagged($review_id)
    {   
        $is_flagged = ReviewFlags::where('user_id', auth()->id())->where('review_id', $review_id)->first();

        if($is_flagged) {
            return true;
        }else {
            return false;
        }
    }
}
