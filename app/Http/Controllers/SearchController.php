<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Industry;
use App\Speciality;
use App\Company;
use Auth;
use DB;
use Session;
use App\User;

class SearchController extends Controller
{
    public function filter_opportunities(Request $request, Project $project,Industry $industry, Speciality $speciality, Company $company)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
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
            if ($request->has('industry') && !$request['industry'] == '') {
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
            if ($request->has('industry') && !$request['industry'] == '') {
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
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
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
            if ($request->has('industry') && !$request['industry'] == '') {
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
            if ($request->has('industry') && !$request['industry'] == '') {
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
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        //check if the user has a company
        $hasCompany = $company->where('user_id', Auth::id())->first();
        //search for companies
        $companies = app(\LaravelCloudSearch\CloudSearcher::class)->newQuery();
        $companies = $companies->searchableType(\App\Company::class)
        ->qAnd(function ($q) use ($request, $hasCompany) {
            $q->phrase($request['s'])
            ->term(1, 'status');
            if(Auth::user()) {
                $q->term(auth()->user()->user_city, 'city');
                if($hasCompany) {
                    $q->term(Auth::user()->company->industry->id, 'industry_id');
                }
            }                   
        })->sort('relevance_score', 'desc')->paginate(10);
        //search for projects
        $projects = app(\LaravelCloudSearch\CloudSearcher::class)->newQuery();
        $projects = $projects->searchableType(\App\Project::class)
        ->qAnd(function ($q) use ($request, $hasCompany) {
            $q->phrase($request['s'])
            ->term('publish', 'status');
            if(Auth::user()) {
                $q->term(auth()->user()->user_city, 'city');
                if($hasCompany) {
                    $q->term(Auth::user()->company->industry->id, 'industry_id');
                }
            }                   
        })->sort('created_at', 'desc')->paginate(10);

        return view('front.search.index', compact('companies', 'projects'));
    }

    //Moderator Dashboard

    public function moderator_filter_companies(Request $request, Company $company,Industry $industry, Speciality $speciality)
    {   
        /*$locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }*/
        
        $industries = Industry::whereIn('display', ['companies', 'both'])->orderBy('industry_name_ar')->get();
        $filter_industry = $request['industry'];
        //if selected all industries go to all opportunities page
        if($request['industry'] == '' && !$request->has('status') && $request['s'] == '') {

            return redirect(route('moderator.companies.dashboard'));

        }

        $company = $company->newQuery();

        if ($request->has('status') && $request['status'] != '') {
            //$with_reps = DB::table('mod_company_reports')->where('status', $request['status'])->pluck('company_id')->toArray();
            $company->where('mod_status', $request['status']);

        }
        if ($request->has('manager_id') && $request['manager_id'] != '') {
            $company->where('manager_id', $request['manager_id']);
        }
        if ($request->has('moderator') && $request['moderator'] != '') {
            $company->where('manager_id', $request['moderator']);
        }
        if ($request->has('industry') && !$request['industry'] == '') {
            $company->where('industry_id', $request['industry']);
        }
        if ($request->has('s')) {
            $company->where('company_name', 'like', '%' . $request['s'] . '%');
        }
        $companies = $company->where('city', $request['city'])->latest()->paginate(50);

        $moderators = User::whereHas('roles', function($q){
            $q->where('name', 'moderator');
        })->get();

        $status_array = array(
            '',
            'In Queue', 'Successful Call - Interested', 'Successful Call - Not Interested',
            'Successful Call - Agreed to Call Back', 'Successful Call - Asked for more details via email',
            'Unsuccessful Call - Unreachable', 'Unsuccessful Call - Wrong number',
            'Unsuccessful Call - No answer'
        );
        if(!$company) {
            $company = new Company;
        }
        return view('admin.moderator-dashboard-companies', compact('industries', 'industry', 'companies', 'specialities', 'filter_industry', 'status_array', 'company', 'moderators')); 
    }

    //Superadmin Search
    public function superadmin_filter_companies(Request $request, Company $company,Industry $industry, Speciality $speciality)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        
        $industries = Industry::whereIn('display', ['companies', 'both'])->orderBy('industry_name_ar')->get();
        $filter_industry = $request['industry'];
        //if selected all industries go to all opportunities page
        if($request['industry'] == '' && !$request->has('status') && $request['s'] == '') {

            return redirect(route('admin.companies'));

        }

        $company = $company->newQuery();

        if ($request->has('industry') && !$request['industry'] == '') {
            $company->where('industry_id', $request['industry']);
        }
        if ($request->has('s')) {
            $company->where('company_name', 'like', '%' . $request['s'] . '%');
        }
        $companies = $company->where('city', $request['city'])->paginate(50);

        if(!$company) {
            $company = new Company;
        }
        return view('admin.company.search-results', compact('industries', 'industry', 'companies', 'specialities', 'filter_industry', 'company')); 
    }

    public function superadmin_filter_users(User $user, Request $request)
    {
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        if ($request->has('s')) {
            $users = $user->where('first_name', 'like', '%' . $request['s'] . '%')
            ->orWhere('last_name', 'like', '%' . $request['s'] . '%')
            ->orWhere('email', 'like', '%' . $request['s'] . '%')->paginate(50);
        }

        return view('admin.users.search-results', compact('users'));
    }

    public function superadmin_filter_projects(Request $request, Project $project,Industry $industry, Speciality $speciality)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        
        $industries = Industry::whereIn('display', ['projects', 'both'])->orderBy('industry_name_ar')->get();
        $filter_industry = $request['industry'];
        //if selected all industries go to all opportunities page
        if($request['industry'] == '' && !$request->has('status') && $request['s'] == '') {

            return redirect(route('admin.projects'));

        }

        $project = $project->newQuery();

        if ($request->has('industry')) {
            $project->with('industries')->whereHas('industries', function ($q) use ($industry, $request) {
                $q->where('industries.id', $request['industry']);
            });
        }
        if ($request->has('s')) {
            $project->where('project_title', 'like', '%' . $request['s'] . '%');
        }
        $projects = $project->where('city', $request['city'])->paginate(50);

        if(!$project) {
            $project = new Project;
        }
        return view('admin.project.search-results', compact('industries', 'industry', 'projects', 'specialities', 'filter_industry', 'company')); 
    }
}
