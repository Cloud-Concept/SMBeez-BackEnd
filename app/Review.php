<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //company relationship
    public function company() {
        return $this->belongsTo(Company::class);
    }
    //user relationship
    public function user() {
        return $this->belongsTo(User::class);
    }
}
