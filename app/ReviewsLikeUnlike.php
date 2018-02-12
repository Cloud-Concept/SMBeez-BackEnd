<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewsLikeUnlike extends Model
{
    //review relationship
    public function review() {
        return $this->belongsTo(Review::class);
    }
}
