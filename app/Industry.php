<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Industry extends Model
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
                'source' => 'industry_name'
            ]
        ];
    }

	//setting up relationship
    public function companies() {
        return $this->belongsToMany(Company::class);
    }

    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
