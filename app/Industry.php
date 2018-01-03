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
        return $this->hasMany(Company::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class)
        ->where('status', 'publish')
        ->where('city', auth()->user()->user_city);
    }

    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
