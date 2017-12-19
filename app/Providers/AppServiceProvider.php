<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        view()->composer('layouts.main-menu', function ($view) {
            // set the view industries from industries method
            $company = new \App\Company;
            $view->with('industries', \App\Industry::all());
            $view->with('hascompany',   $company->has_company());
            $view->with('mycompany', $company->where('user_id', auth()->id())->first());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
