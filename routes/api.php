<?php

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Project;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('companies/all', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Company::all();
});

Route::get('projects/all', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Project::all();
});

//suggest specialities for project and companies creation
Route::get('find', function(Illuminate\Http\Request $request){
    $keyword = $request->input('keyword');

    $specialities = DB::table('specialities')->where('speciality_name','like','%'.$keyword.'%')
              ->select('specialities.id','specialities.speciality_name')
              ->take(10)
              ->get();

    $data = array();

    foreach($specialities as $spec) {
        $data[] = $spec->speciality_name;
    }
    return json_encode($data);
})->name('api.specialities');


//suggest companies during company creation, it must be un verified
Route::get('company-suggest', function(Illuminate\Http\Request $request){
    $keyword = $request->input('keyword');
    //check for un verified companies
    $companies = DB::table('companies')->where('company_name','like','%'.$keyword.'%')
              ->where('is_verified', null)
              ->select('companies.id','companies.company_name')
              ->take(10)
              ->get();

    $data = array();

    foreach($companies as $spec) {
        $data[] = $spec->company_name;
    }
    return json_encode($data);
})->name('api.companies.suggest');

//Route::get('/search', 'SearchController@filter_opportunities')->name('filter.opportunities');

