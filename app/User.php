<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Role;
use App\Company;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //company relationship
    function company() {
        $this->hasMany(Company::class);
    }

    //project relationship
    function project() {
        $this->hasMany(Project::class);
    }
    //interests relationship
    function interests() {
        $this->hasMany(Interest::class);
    }
}
