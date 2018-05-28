<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function review() {
        return $this->belongsTo(Review::class);
    }

    //Likes & Unlikes
    public function likes() {
        return $this->hasMany(RepliesLikeUnlike::class);
    }

    public function impression($reply_id)
    {   
        $check_like = RepliesLikeUnlike::where('user_id', auth()->id())->where('reply_id', $reply_id)->first();

        if($check_like) {
            return $check_like->type;
        }else {
            return '';
        }
    }
}
