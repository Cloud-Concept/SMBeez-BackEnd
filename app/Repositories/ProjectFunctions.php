<?php  
namespace App\Repositories;
use \App\EmailLogs;
use \App\UserLogins;
use \App\Setting;
use \App\Point;
use \App\Company;
use Carbon\Carbon;
use DB;

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
	public function addPoints($action, $company, $limit_type) {
		$point = new \App\Point;
		$setting = new \App\Setting;
		$assigned_company = new \App\Company;
		//Get Points Assigned to Action
		$points = $setting->where('setting_slug', $action)->pluck('value')->first();
		$max_allowed_points = $setting->where('setting_slug', 'maximum-allowed-points')->pluck('value')->first();
		$company_available_points = $assigned_company->where('id', $company)->pluck('points')->first();
		//first role if company points < max allowed points go on..
		if($company_available_points < $max_allowed_points) {
			//second role check if the company made this action of lifetime type another time
			$ifLifetime = $point->where('company_id', $company)
				->where('action', $action)
				->where('limit_type', 'lifetime')->first();

			if(!$ifLifetime) {
				//check the limit usage of the action during the month
				$actionEarn = DB::table('points')->where('company_id', $company)
					->where('action', $action)->sum('points');
				$actionLimit = $setting->where('setting_slug', $action)->pluck('limit')->first();
				if($actionEarn == $actionLimit) {
					session()->flash('success', 'لقد وصلت الي الحد الاقصي للنقاط.');
					return false;
				}else {
					//if the points available are not sufficient to the deduction.
					if($points < 0 && abs($points) > $company_available_points) {
						session()->flash('success', 'لا يوجد لديك نقاط كافية.');
						return false;
					}else {
						//Add Points
						$point->points = abs($points);
						$point->company_id = $company;
						$point->action = $action;
						$point->limit_type = $limit_type;
						$point->expiry_date = new Carbon('first day of next month', 'Africa/Cairo');
						if($points > 0) {
							session()->flash('success', 'تم اضافة ' .$points. ' نقطة الي رصيدك.');
						}else{
							session()->flash('success', 'تم خصم ' .abs($points). ' نقطة من رصيدك.');
						}
						$point->save();
						if($points > 0) {
							return $point->company->increment('points', $points);
						}else {
							return $point->company->decrement('points', abs($points));
						}
					}
				}
			}else {
				//return nothing cuz he already awarded points for this lifetime action
				return false;
			}
		}else {
			session()->flash('success', 'لقد وصلت الي الحد الاقصي للنقاط.');
			return false;
		}

	}

}
?>