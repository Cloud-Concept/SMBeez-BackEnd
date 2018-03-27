<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{	
	protected $fillable = ['user_id', 'bookmarked_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }


    public function bookmarked_projects($project_id) {

    	return Project::where('id', $project_id)->first();

    }

    public function bookmarked_companies($company_id) {

    	return Company::where('id', $company_id)->first();

    }

    static public function exist($bookmarked_id, $bookmark_type)
    {   
        $exist = Bookmark::where('user_id', auth()->id())
        ->where('bookmarked_id', $bookmarked_id)
        ->where('bookmark_type', $bookmark_type)
        ->first();

        if($exist) {
            return true;
        }else {
            return false;
        }
    }
}
