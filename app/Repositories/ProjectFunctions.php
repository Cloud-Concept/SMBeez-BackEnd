<?php  
namespace App\Repositories;
use \App\EmailLogs;
use \App\UserLogins;
use \App\Setting;
use \App\Point;
use Carbon\Carbon;

class ProjectFunctions {

	public function get_last_word($amount, $string, $action)
	{
	    $amount+=1;
	    $string_array = explode($action, $string);
	    $totalwords= str_word_count($string, 1, 'àáãç3');
	    if($totalwords > $amount){
	        $words= implode(' ',array_slice($string_array, count($string_array) - $amount));
	    }else{
	        $words= implode(' ',array_slice($string_array, count($string_array) - $totalwords));
	    }

	    return $words;
	}

	public function email_log($user, $email) {
		$email_logs = new \App\EmailLogs;

		$email_logs->user_id = $user;
		$email_logs->recipient_email = $email;

		return $email_logs->save();
	}

	public function user_logins($user) {
		$user_login = new \App\UserLogins;

		$user_login->user_id = $user;
		return $user_login->save();
	}

	public function csm_company($user, $company, $action) {
		$csmTracking = new \App\CsmTracking;

		$csmTracking->user_id = $user;
		$csmTracking->company_id = $company;
		$csmTracking->activity_type = $action;
		return $csmTracking->save();
	}
	//Add Points Function
	public function points($action, $company, $limit, $limit_type) {
		$point = new \App\Point;
		$setting = new \App\Setting;
		//Get Points Assigned to Action
		$points = $setting->where('setting_slug', $action)->pluck('value')->first();
		//Add Points
		$point->points = $points;
		$point->company_id = $company;
		$point->action = $action;
		$point->limit = $limit;
		$point->limit_type = $limit_type;
		$point->expiry_date = new Carbon('first day of next month', 'Africa/Cairo');
		
		return $point->save();

	}

}
?>