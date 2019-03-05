<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function action_points($action) {
    	return $this->where('setting_slug', $action)->pluck('value')->first();
    } 
}
