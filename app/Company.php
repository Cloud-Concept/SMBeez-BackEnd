<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use DB;

class Company extends Model
{	
	use Sluggable;
    /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
    */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'company_name'
            ]
        ];
    }

	//user relationship
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function industry() {
        return $this->belongsTo(Industry::class);
    }

    public function specialities() {
        return $this->belongsToMany(Speciality::class);
    }
    //reviews relationship
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    //check if user is a manager of a company
    public function has_company()
    {
        $hasCompany = Company::where('user_id', auth()->id())->first();

        if($hasCompany) {
            return true;
        }else {
            return false;
        }

    }
    //check if the user is the owner of this company
    public function is_owner($user) {
        return $this->user_id === auth()->id();
    }

    public function company_overall_rating($id)
    {   
       if($this->reviews->count() > 0) {  
            //sum of all reviews rates
            $company_overall_rating = DB::table('reviews')
            ->select(DB::raw("SUM(overall_rate + selection_process_rate + money_value_rate + delivery_quality_rate)"))
            ->where('company_id', $id)->get();
            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 4 which means 4 types of rates
            foreach ($company_overall_rating[0] as $key => $value) {
                $value = (int)$value;
            }
            
            $company_overall_rating = ceil($value / ( $this->reviews->count() * 4));
            //displaying over all rating of the company
            return $company_overall_rating;
        }
    }
    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
