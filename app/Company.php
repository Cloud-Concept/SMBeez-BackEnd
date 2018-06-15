<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use DB;
use App\Bookmark;


class Company extends Model
{	
	use Sluggable;

    protected $fillable = ['relevance_score'];

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
    //files relationship
    public function files() {
        return $this->hasMany(MyFile::class);
    }
    //claims relationship
    public function claims() {
        return $this->hasOne(Claim::class);
    }
    public function mod_report() {

        return $this->hasOne(ModCompanyReport::class);

    }
    public function mod_logs() {

        return $this->hasMany(ModLog::class);

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
    public function exist($field, $company)
    {   
        $exist = Company::where($field, $company)->first();

        if($exist) {
            return true;
        }else {
            return false;
        }
    }
    //check if user created claim request
    public function requested_claim($user, $company)
    {
        $requested_claim = Claim::where('user_id', $user)->where('company_id', $company)->first();

        if($requested_claim) {
            return true;
        }else {
            return false;
        }

    }
    //check if the user is the owner of this company
    public function is_owner($user) {
        return $this->user_id === auth()->id();
    }

    public function company_overall_rating($company_id)
    {   
       if($this->reviews->count() > 0) {  
            //sum of all reviews rates
            $company_overall_rating = DB::table('reviews')
            ->select(DB::raw("SUM(overall_rate + business_repeat + time + cost + quality + procurement + expectations + payments)"))
            ->where('company_id', $company_id)->get();

            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 5 which means 5 types of rates
            foreach ($company_overall_rating[0] as $key => $value) {
                $value = (int)$value;
            }
            
            $company_overall_rating = ceil($value / ( $this->reviews->count() * 5));
            //displaying over all rating of the company
            return $company_overall_rating;
        }
    }
    //used to get fraction
    public function company_overall_exact_rating($company_id)
    {   
       if($this->reviews->count() > 0) {  
            //sum of all reviews rates
            $company_overall_rating = DB::table('reviews')
            ->select(DB::raw("SUM(overall_rate + business_repeat + time + cost + quality + procurement + expectations + payments)"))
            ->where('company_id', $company_id)->get();

            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 5 which means 5 types of rates
            foreach ($company_overall_rating[0] as $key => $value) {
                $value = (int)$value;
            }
            
            $company_overall_rating = $value / ( $this->reviews->count() * 5);
            //displaying over all rating of the company
            return $company_overall_rating;
        }
    }
    //get customer rating
    public function customer_rating($company_id, $customer_reviews)
    {   
        if($this->reviews->count() > 0) {
            //sum of all reviews rates
            $customer_overall = DB::table('reviews')
            ->select(DB::raw("SUM(quality + cost + time + business_repeat + overall_rate)"))
            ->where('company_id', $company_id)
            ->where('reviewer_relation', 'customer')->get();

            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 5 which means 5 types of rates
            foreach ($customer_overall[0] as $key => $value) {
                $value = (int)$value;
            }
            if($value > 0) {
                return $customer_overall = ceil($value / ($customer_reviews->count() * 5));
            }
        } 
    }
    //suppliers rating
    public function suppliers_rating($company_id, $suppliers_reviews)
    {   
        if($this->reviews->count() > 0) {
            //sum of all reviews rates
            $suppliers_overall = DB::table('reviews')
            ->select(DB::raw("SUM(overall_rate + business_repeat + procurement + expectations + payments)"))
            ->where('company_id', $company_id)
            ->where('reviewer_relation', 'supplier')->get();

            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 5 which means 5 types of rates
            foreach ($suppliers_overall[0] as $key => $value) {
                $value = (int)$value;
            }
            if($value > 0) {
                return $suppliers_overall = ceil($value / ($suppliers_reviews->count() * 5));
            }
        }
    }
    public function bookmarked($company_id) {
        $bookmarked = Bookmark::exist($company_id, 'App\Company');

        if($bookmarked) {
            return true;
        }else {
            return false;
        }
    }

    public function bookmark($bookmarked_id)
    {
        return Bookmark::where('user_id', auth()->id())
        ->where('bookmarked_id', $bookmarked_id)
        ->where('bookmark_type', 'App\Company')
        ->pluck('id')
        ->first();
    }

    public static function addRelevanceScore($score, $company_id) {
        $company = Company::where('id', $company_id);
        $current = $company->pluck('relevance_score')->first();
        return $company->update(array('relevance_score' => $current + $score));
    }
    //use slug to get company
    public function getRouteKeyName() {
        return 'slug';
    }
}
