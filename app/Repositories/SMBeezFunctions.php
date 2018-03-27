<?php  
namespace App\Repositories;

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

}
?>