<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('front.home');
})->name('home');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


//Dashboard for admins only
Route::prefix('admin')->middleware('role:superadmin|administrator')->group(function() {
	Route::get('/', 'AdminController@index');
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
	//User Module
	Route::get('/manage/users', 'UserController@index')->name('admin.user.index');
	Route::get('/manage/users/create', 'UserController@create')->name('admin.user.create');
	Route::post('/manage/users/store', 'UserController@store')->name('admin.user.store');
	Route::get('/manage/users/edit/{user}', 'UserController@edit')->name('admin.user.edit');
	Route::post('/manage/users/update/{user}', 'UserController@update')->name('admin.user.update');
	Route::delete('/manage/users/delete/{user}', 'UserController@destroy')->name('admin.user.delete');
	//Industries Module
	Route::get('/manage/industries/create', 'IndustriesController@create')->name('admin.industry.create');
	Route::post('/manage/industries/store', 'IndustriesController@store')->name('admin.industry.store');
	//Specialities Module
	Route::get('/manage/specialities/create', 'SpecialitiesController@create')->name('admin.speciality.create');
	Route::post('/manage/specialities/store', 'SpecialitiesController@store')->name('admin.speciality.store');

});

Route::prefix('user')->group(function() {
	Route::get('/dashboard/{user}', 'UserController@dashboard')->name('front.user.dashboard');
	Route::get('/dashboard/{user}/myprojects', 'UserController@myprojects')->name('front.user.myprojects');
	Route::get('/dashboard/{user}/opportunities', 'UserController@opportunities')->name('front.user.opportunities');
	//Company Module
	Route::post('/company/store', ['middleware' => ['permission:create-company', 'role:user|superadmin'], 'uses' => 'CompaniesController@store'])->name('front.company.store');
	Route::get('/company/create', ['middleware' => ['permission:create-company', 'role:user|superadmin'], 'uses' => 'CompaniesController@create'])->name('front.company.create');

});

Route::prefix('companies')->group(function() {
	Route::get('/all', 'CompaniesController@index')->name('front.company.all');
	Route::get('/{company}', 'CompaniesController@show')->name('front.company.show');
	Route::get('/{company}/edit', 'CompaniesController@edit')->name('front.company.edit');
	Route::get('/industries/{industry}', 'CompaniesController@show_industry')->name('front.company.showindustry');
});


Route::prefix('industries')->group(function() {
	Route::get('/{industry}', 'IndustriesController@show')->name('front.industry.show');
});

Route::prefix('projects')->group(function() {
	Route::post('/store', ['middleware' => ['permission:create-project', 'role:company|superadmin'], 'uses' => 'ProjectsController@store'])->name('front.project.store');
	Route::get('/create', ['middleware' => ['permission:create-project', 'role:company|superadmin'], 'uses' => 'ProjectsController@create'])->name('front.project.create');
	Route::get('/{project}', 'ProjectsController@show')->name('front.project.show');
	Route::post('close/{project}', 'ProjectsController@close')->name('front.project.close');
});


//Send Express Interest Request
Route::post('/interest/store', ['middleware' => ['role:company|superadmin'], 'uses' => 'InterestsController@store'])->name('express.interest');
Route::delete('/interest/delete/{interest}', ['middleware' => ['role:company|superadmin'], 'uses' => 'InterestsController@destroy'])->name('withdraw.interest');
Route::post('/interest/{interest}/accept', ['middleware' => ['role:company|superadmin'], 'uses' => 'InterestsController@accept_interest'])->name('accept.interest');
Route::post('/interest/{interest}/decline', ['middleware' => ['role:company|superadmin'], 'uses' => 'InterestsController@decline_interest'])->name('decline.interest');
Route::post('/review/store', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@store'])->name('add.review');
