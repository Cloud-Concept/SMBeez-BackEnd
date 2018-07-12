<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModCompanyReport extends Model
{
    public function company() {

    	return $this->belongsTo(Company::class);

    }

    public function user() {

    	return $this->belongsTo(User::class);

    }
}
