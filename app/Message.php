<?php

namespace App;

use App\Interest;
use App\Company;
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

    public function message_company_exists($sender_id) {

        $company_exists = Company::where('user_id', $sender_id)->first();

        if($company_exists) {
            return true;
        }else {
            return false;
        }


    }
}
