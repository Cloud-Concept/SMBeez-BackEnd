<?php

namespace App;

use App\Interest;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user() {

    	return $this->belongsTo(User::class);

    }

    public function interest_status($interest_id) {

    	$interest = new Interest;

    	$interest = $interest->where('id', $interest_id)->first();
    	if($interest) {
    		return $interest->is_accepted;
    	}else {
    		return false;
    	}
    }
}
