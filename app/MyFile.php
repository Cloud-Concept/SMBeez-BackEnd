<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFile extends Model
{	
	//user relationship
    public function user() {
    	return $this->belongsTo(User::class);
    }
    //company relationship
    public function company() {
    	return $this->belongsTo(Company::class);
    }
    //project relationship
    public function project() {
    	return $this->belongsTo(Project::class);
    }
}
