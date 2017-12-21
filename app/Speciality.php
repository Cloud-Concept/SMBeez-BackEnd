<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Speciality extends Model
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
                'source' => 'speciality_name'
            ]
        ];
    }


    //setting up relationship
    public function companies() {
        return $this->belongsToMany(Company::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
