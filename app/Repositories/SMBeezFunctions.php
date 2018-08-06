<?php  
namespace App\Repositories;
use \App\EmailLogs;
use \App\UserLogins;

class SMBeezFunctions {

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

}
?>