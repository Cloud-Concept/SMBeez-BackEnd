<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
