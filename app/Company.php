<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Company extends Model
{	
	use Sluggable;
    /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
    */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'company_name'
            ]
        ];
    }

	//user relationship
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function industries() {
        return $this->belongsToMany(Industry::class);
    }
    //check if user is a manager of a company
    public function has_company()
    {
        $hasCompany = Company::where('user_id', auth()->id())->first();

        if($hasCompany) {
            return true;
        }else {
            return false;
        }

    }
    //check if the user is the owner of this company
    public function is_owner($user) {
        return $this->user_id === auth()->id();
    }
    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
