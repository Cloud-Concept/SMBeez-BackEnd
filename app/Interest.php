<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
