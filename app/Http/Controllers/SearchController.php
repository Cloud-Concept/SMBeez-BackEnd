<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Industry;
use App\Speciality;
use App\Company;
use Auth;
use DB;

class SearchController extends Controller
{
    public function filter_opportunities(Request $request, Project $project,Industry $industry, Speciality $speciality, Company $company)
    {	
        //check if the user has a company
        $hasCompany = $company->where('user_id', Auth::id())->first();

        $industries = $industry->all();
        $companies = $company->all();
        $specialities = $speciality->all();
        $filter_industry = $request['industry'];
        //if selected all industries go to all opportunities page
        if($request['industry'] == 'all') {

            return redirect(route('front.industry.index'));

        }

    	$project = $project->newQuery();

        //get the requested specialities
    	if ($request->has('specialities')) {
    		$project->with('specialities')->whereHas('specialities', function ($q) use ($speciality, $request) {
	            $q->whereIn('specialities.id', $request['specialities']);
	        });
    	}

        if(Auth::user()) {
            //if user signed in so find the user's company industry and get use it with request
            $project->with('industries')->whereHas('industries', function ($q) use ($industry, $request, $hasCompany) {
                $q->where('industries.id', $hasCompany ? Auth::user()->company->industry->id : $request['industry']);
            });

            $industry_projects = $project->where('status', 'publish')
            ->where('city', auth()->user()->user_city)->latest()->paginate(10);


            $featured_projects = $project->whereHas('industries', function ($q) use ($industry, $request) {
                    $q->where('industries.id', $request['industry']);
                })
                ->where('is_promoted', 1)
                ->where('status', 'publish')
                ->where('city', Auth::user()->user_city)
                ->orderBy(DB::raw('RAND()'))
                ->take(2)
                ->get();
        }else {
            //get the requested industry
            if ($request->has('industry')) {
                $project->with('industries')->whereHas('industries', function ($q) use ($industry, $request) {
                    $q->where('industries.id', $request['industry']);
                });
            }

            $industry_projects = $project->where('status', 'publish')->latest()->paginate(10);


            $featured_projects = $project->whereHas('industries', function ($q) use ($industry, $request) {
                    $q->where('industries.id', $request['industry']);
                })
                ->where('is_promoted', 1)
                ->where('status', 'publish')
                ->orderBy(DB::raw('RAND()'))
                ->take(2)
                ->get();
        }

    	return view('front.industry.show', compact('industries', 'industry', 'hasCompany', 'industry_projects', 'companies', 'featured_projects', 'specialities', 'filter_industry')); 
    }
}
