<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\User;

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
    function user() {
    	$this->belongsTo(User::class);
    }

   //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
