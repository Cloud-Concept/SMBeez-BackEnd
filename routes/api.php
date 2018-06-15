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

//Moderator
Route::get('get-company/{company}', 'AdminController@get_company')->name('get-company-ajax');
Route::post('update-company/{company}', 'AdminController@update_company')->name('update-company-ajax');
Route::post('assign-company-to-user/{company}', 'AdminController@assign_company_to_user')->name('assign-company-ajax');
Route::post('create-user-to-company/{company}', 'AdminController@create_user_to_company')->name('user-company-ajax');
Route::get('get-company-report/{company}', 'AdminController@get_company_report')->name('get-company-report-ajax');
Route::post('create-update-company-report/{company}', 'AdminController@create_update_company_report')->name('create-update-company-report-ajax');
Route::post('send-mod-msg/{company}', 'AdminController@send_mod_message')->name('send-mod-msg-ajax');
Route::post('upload-company-imgs/{company}', 'CompaniesController@update_logo_cover')->name('update-company-imgs');
//Route::get('/search', 'SearchController@filter_opportunities')->name('filter.opportunities');

