<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Project extends Model
{
    protected $dates = ['close_date'];

    use Sluggable;
    /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
    */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'project_title'
            ]
        ];
    }

    public function industries() {
        return $this->belongsToMany(Industry::class);
    }

    //user relationship
    public function user() {
    	return $this->belongsTo(User::class);
    }

    //use slug to get project
    public function getRouteKeyName() {
        return 'slug';
    }
}
