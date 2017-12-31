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
    public function company() {
        return $this->hasOne(Company::class);
    }

    //project relationship
    public function projects() {
        return $this->hasMany(Project::class);
    }
    //interests relationship
    public function interests() {
        return $this->hasMany(Interest::class);
    }
    //reviews relationship
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    //check for profile completion
    public function profile_completion() {

        $count_empty = '';
        return $count_empty;
    }

    //check for dashboard owner
    public function dashboard_owner($user) {
        return $this->id === auth()->id();
    }
    //use slug to get dashboard
    public function getRouteKeyName() {
        return 'username';
    }
}
