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
        if($request['industry'] == '' && !$request->has('specialities') && $request['s'] == '') {

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
            if ($request->has('industry')) {
                $project->with('industries')->whereHas('industries', function ($q) use ($industry, $request, $hasCompany) {
                    $q->where('industries.id', $hasCompany ? Auth::user()->company->industry->id : $request['industry']);
                });
            }

            if ($request->has('s')) {
                $project->where('project_title', 'like', '%' . $request['s'] . '%');
            }

            $industry_projects = $project->where('status', 'publish')
            ->where('city', auth()->user()->user_city)->orderBy('relevance_score', 'desc')->orderBy('created_at', 'desc')->paginate(10);


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

            if ($request->has('s')) {
                $project->where('project_title', 'like', '%' . $request['s'] . '%');
            }

            $industry_projects = $project->where('status', 'publish')->orderBy('relevance_score', 'desc')->orderBy('created_at', 'desc')->paginate(10);


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

    public function filter_companies(Request $request, Company $company,Industry $industry, Speciality $speciality)
    {   
        //check if the user has a company
        $hasCompany = $company->where('user_id', Auth::id())->first();

        $industries = $industry->all();
        $specialities = $speciality->all();
        $filter_industry = $request['industry'];
        //if selected all industries go to all opportunities page
        if($request['industry'] == '' && !$request->has('specialities') && $request['s'] == '') {

            return redirect(route('front.company.all'));

        }

        $company = $company->newQuery();

        //get the requested specialities
        if ($request->has('specialities')) {
            $company->with('specialities')->whereHas('specialities', function ($q) use ($speciality, $request) {
                $q->whereIn('specialities.id', $request['specialities']);
            });
        }

        if(Auth::user()) {
            //if user signed in so find the user's company industry and get use it with request
            if ($request->has('industry')) {
                $company->where('industry_id', $hasCompany ? Auth::user()->company->industry->id : $request['industry']);
            }
            if ($request->has('s')) {
                $company->where('company_name', 'like', '%' . $request['s'] . '%');
            }
            $companies = $company->where('status', 1)
            ->where('city', auth()->user()->user_city)->orderBy('relevance_score', 'desc')->paginate(10);


            $featured_companies = $company->where('industry_id', $hasCompany ? Auth::user()->company->industry->id : $request['industry'])
                ->where('is_promoted', 1)
                ->where('status', 1)
                ->where('city', Auth::user()->user_city)
                ->orderBy(DB::raw('RAND()'))
                ->take(2)
                ->get();
        }else {
            //get the requested industry
            if ($request->has('industry')) {
                $company->where('industry_id', $request['industry']);
            }

            if ($request->has('s')) {
                $company->where('company_name', 'like', '%' . $request['s'] . '%');
            }

            $companies = $company->where('status', 1)
            ->orderBy('relevance_score', 'desc')->paginate(10);


            $featured_companies = $company->where('industry_id', $request['industry'])
                ->where('is_promoted', 1)
                ->where('status', 1)
                ->orderBy(DB::raw('RAND()'))
                ->take(2)
                ->get();
        }

        return view('front.company.index', compact('industries', 'industry', 'hasCompany', 'companies', 'featured_companies', 'specialities', 'filter_industry')); 
    }

    public function search(Request $request, Company $company, Project $project, Industry $industry)
    {   
        //check if the user has a company
        $hasCompany = $company->where('user_id', Auth::id())->first();

        if(Auth::user()) {
            //if user signed in so find the user's company industry and get use it with request
            $companies = $company->where('company_name', 'like', '%' . $request['s'] . '%')->where('status', 1)
            ->where('city', auth()->user()->user_city)->orderBy('relevance_score', 'desc')->paginate(10);
            if($hasCompany) {
                $companies->where('industry_id', Auth::user()->company->industry->id);
            }

            $project->with('industries')->whereHas('industries', function ($q) use ($industry, $request, $hasCompany) {
                $q->where('industries.id', $hasCompany ? Auth::user()->company->industry->id : '');
            });

            $projects = $project->where('project_title', 'like', '%' . $request['s'] . '%')->where('status', 'publish')
            ->where('city', auth()->user()->user_city)->orderBy('relevance_score', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        
            if($hasCompany) {
                $companies_count = $company->where('company_name', 'like', '%' . $request['s'] . '%')->where('status', 1)
                ->where('city', auth()->user()->user_city)->where('industry_id', Auth::user()->company->industry->id)->get()->count();
            }else {
                $companies_count = $company->where('company_name', 'like', '%' . $request['s'] . '%')->where('status', 1)
                ->where('city', auth()->user()->user_city)->get()->count();
            }
            $projects_count = $project->where('project_title', 'like', '%' . $request['s'] . '%')->where('status', 'publish')
            ->where('city', auth()->user()->user_city)->get()->count();

        }else {
            $companies = $company->where('company_name', 'like', '%' . $request['s'] . '%')->where('status', 1)
            ->orderBy('relevance_score', 'desc')->paginate(10);

            $projects = $project->where('project_title', 'like', '%' . $request['s'] . '%')->where('status', 'publish')
            ->orderBy('relevance_score', 'desc')->orderBy('created_at', 'desc')->paginate(10);

            $companies_count = $company->where('company_name', 'like', '%' . $request['s'] . '%')->where('status', 1)
            ->get()->count();
            $projects_count = $project->where('project_title', 'like', '%' . $request['s'] . '%')->where('status', 'publish')
            ->get()->count();

        }

        return view('front.search.index', compact('companies', 'projects', 'companies_count', 'projects_count', 'scores'));
    }

    //Moderator Dashboard

    public function moderator_filter_companies(Request $request, Company $company,Industry $industry, Speciality $speciality)
    {   

        $industries = $industry->all();
        $filter_industry = $request['industry'];
        //if selected all industries go to all opportunities page
        if($request['industry'] == '' && !$request->has('status') && $request['s'] == '') {

            return redirect(route('moderator.companies.dashboard'));

        }

        $company = $company->newQuery();

        /*if ($request->has('status')) {
            if($request['status'] == 'In Queue') {
               $company->with('mod_report')->whereHas('mod_report', function ($q) use ($request) {
                    $q->where('mod_company_reports.company_id', '!=', 'companies.id');
                }); 
            }else {
                $company->with('mod_report')->whereHas('mod_report', function ($q) use ($request) {
                    $q->where('mod_company_reports.status', $request['status']);
                });
            }
        }*/
        if ($request->has('industry')) {
            $company->where('industry_id', $request['industry']);
        }
        if ($request->has('s')) {
            $company->where('company_name', 'like', '%' . $request['s'] . '%');
        }
        $companies = $company->where('city', $request['city'])->paginate(10);

        return view('admin.moderator-dashboard-companies', compact('industries', 'industry', 'companies', 'specialities', 'filter_industry')); 
    }
}
