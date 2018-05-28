<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepliesLikeUnlike extends Model
{
    //review relationship
    public function reply() {
        return $this->belongsTo(Reply::class);
    }
}
