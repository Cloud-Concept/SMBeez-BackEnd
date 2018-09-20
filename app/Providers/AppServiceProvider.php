<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Register a composer with the name of the view when it's loaded in our case the view is layouts.main-menu
        view()->composer(['layouts.main-menu', 'front.home', 'layouts.footer', 'front.users.myprojects', 'front.users.opportunities', 'front.users.messages', 'front.users.show-message', 'front.users.bookmarks', 'front.users.companies-bookmarks', 'front.users.opportunities-bookmarks', 'front.users.settings.basic-info', 'front.users.settings.location', 'front.users.profile', 'layouts.about'], function ($view) {
            // set the view industries from industries method
            $company = new \App\Company;
            if($company->has_company()) {
                $view->with('industries', \App\Industry::with('projects')->whereIn('display', ['projects', 'both'])->orderBy('industry_name', 'asc')->get());
            }else{
                $view->with('industries', \App\Industry::with('companies')->whereIn('display', ['companies', 'both'])->orderBy('industry_name', 'asc')->get());
            }
            $view->with('hascompany',   $company->has_company());
            $view->with('mycompany', $company->where('user_id', auth()->id())->first());
        });

        // register a composer for filter sidebar
        view()->composer(['layouts.filter-sidebar-opportunities', 'admin.project.edit'], function ($view) {
            // set the view industries from industries method
            $view->with('industry', new \App\Industry);
            $view->with('specialities', \App\Speciality::with('projects')->get());
            $view->with('industries', \App\Industry::with('projects')
                ->whereIn('display', ['projects', 'both'])
                ->orderBy('industry_name', 'asc')
                ->get()
            );
        });
        //things related to companies
        view()->composer(['layouts.filter-sidebar-companies', 'admin.company.create', 'admin.company.edit'], function ($view) {
            // set the view industries from industries method
            $view->with('industry', new \App\Industry);
            $view->with('specialities', \App\Speciality::with('companies')->get());
            $view->with('industries', \App\Industry::with('companies')
                ->whereIn('display', ['companies', 'both'])
                ->orderBy('industry_name', 'asc')
                ->get()
            );
        });

        //register a view for express interest popup
        view()->composer('layouts.interests-modal', function ($view) {
            $view->with('user', auth()->user());
        });
        //register view for dashboard menu
        view()->composer('layouts.dashboard-menu', function ($view) {
            $company = new \App\Company;
            $view->with('hascompany',   $company->has_company());
            $view->with('user', auth()->user());
        });
        //for homepage
        view()->composer('front.home', function ($view) {
            // set the view industries from industries method
            if(Auth::user()) {
                $view->with('industry_projects', \App\Project::with('industries')->where('status', 'publish')
                ->where('city', auth()->user()->user_city)->latest()->take(2)->get());

                $view->with('featured_projects', \App\Project::where('is_promoted', 1)
                ->where('status', 'publish')
                ->where('city', auth()->user()->user_city)
                ->orderBy(DB::raw('RAND()'))
                ->take(4)
                ->get());

                $view->with('featured_companies', \App\Company::where('is_promoted', 1)
                ->where('status', '!=', '0')
                ->where('city', auth()->user()->user_city)
                ->orderBy(DB::raw('RAND()'))
                ->take(2)
                ->get());

            }else {
                $view->with('industry_projects', \App\Project::with('industries')->where('status', 'publish')
                ->latest()->take(2)->get());

                $view->with('featured_projects', \App\Project::where('is_promoted', 1)
                ->where('status', 'publish')
                ->orderBy(DB::raw('RAND()'))
                ->take(4)
                ->get());

                $view->with('featured_companies', \App\Company::where('is_promoted', 1)
                ->where('status', '!=', '0')
                ->orderBy(DB::raw('RAND()'))
                ->take(2)
                ->get());

            }

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mailgun.client', function() {
            return \Http\Adapter\Guzzle6\Client::createWithConfig([
                // your Guzzle6 configuration
            ]);
        });
    }
}
