<?php 

namespace App\Repositories;
use App\Company;
use App\Industry;
use App\Speciality;
use Auth;
use DB;

class Companies
{
	
	public function listCompanies()
	{	
        $company = new Company;
        $user = Auth::user();

        $hasCompany = $company->where('user_id', Auth::id())->first();
        $industries = Industry::all();
        $speciality = new Speciality;
        $specialities = $speciality->all();
        //if user logged in so get companies from his profile city
        if($user) {
            
            $featured_companies = $company->where('is_promoted', 1)
            ->where('status', '!=', '0')
            ->where('city', Auth::user()->user_city)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

            $companies = $company->where('city', Auth::user()->user_city)->latest()->paginate(10);
        }else {
            //this will be changed to the selected country from the menu

            $featured_companies = $company->where('is_promoted', 1)
            ->where('status', '!=', '0')
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

            $companies = $company->latest()->paginate(10);
        }
	}
}