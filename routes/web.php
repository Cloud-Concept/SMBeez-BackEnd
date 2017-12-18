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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


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
	Route::get('/manage/industries/create', 'industriesController@create')->name('admin.industry.create');
	Route::post('/manage/industries/store', 'industriesController@store')->name('admin.industry.store');

});

Route::prefix('user')->group(function() {
	//Route::get('/dashboard/{user}', 'UserController@frontDashboard')->name('front.user.dashboard');
	//Company Module
	Route::post('/company/store', ['middleware' => ['permission:create-company', 'role:user|superadmin'], 'uses' => 'CompaniesController@store'])->name('front.company.store');
	Route::get('/company/create', ['middleware' => ['permission:create-company', 'role:user|superadmin'], 'uses' => 'CompaniesController@create'])->name('front.company.create');

});

Route::prefix('companies')->group(function() {
	Route::get('/all', 'CompaniesController@index')->name('front.company.all');
	Route::get('/{company}', 'CompaniesController@show')->name('front.company.show');
});


Route::prefix('industries')->group(function() {
	Route::get('/all', 'IndustriesController@index')->name('front.industry.all');
	Route::get('/{industry}', 'IndustriesController@show')->name('front.industry.show');
});