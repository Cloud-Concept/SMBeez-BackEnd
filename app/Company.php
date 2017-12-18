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

    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
