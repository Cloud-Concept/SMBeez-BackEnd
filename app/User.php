<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Role;
use App\Company;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;

    use Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'user_city', 'phone', 'honeycombs', 'profile_pic_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
    */
    public function sluggable() {
        return [
            'username' => [
                'source' => 'first_name'
            ]
        ];
    }
    //company relationship
    public function company() {
        return $this->hasOne(Company::class);
    }

    //project relationship
    public function projects() {
        return $this->hasMany(Project::class)->where('status', '!=', 'deleted');
    }
    //interests relationship
    public function interests() {
        return $this->hasMany(Interest::class);
    }
    //reviews relationship
    public function reviews() {
        return $this->hasMany(Review::class)->latest();
    }
    //files relationship
    public function files() {
        return $this->hasMany(MyFile::class);
    }
    //messages relationship
    public function messages() {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }
    //bookmarks relationship
    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }
    //claims relationship
    public function claims() {
        return $this->hasOne(Claim::class);
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

    public function getReferrals()
    {
        return ReferralProgram::all()->map(function ($program) {
            return ReferralLink::getReferral($this, $program);
        });
    }

    public function addHoneyCombs($amount)
    {   
        $current_honeycombs = $this->honeycombs;

        return $this->update(['honeycombs'=> $current_honeycombs + $amount]);
    }
    //use slug to get dashboard
    public function getRouteKeyName() {
        return 'username';
    }
}
