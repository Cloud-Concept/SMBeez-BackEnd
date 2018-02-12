<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }


    public function bookmarked_projects($project_id) {

    	return Project::where('id', $project_id)->first();

    }

    public function bookmarked_companies($company_id) {

    	return Company::where('id', $company_id)->first();

    }
}
