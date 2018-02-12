<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
