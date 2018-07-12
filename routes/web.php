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
Route::prefix('admin')->middleware('role:superadmin|administrator|moderator')->group(function() {
	Route::get('/', 'AdminController@index');
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
	Route::get('/dashboard/moderator/companies', 'AdminController@moderator_dashboard_companies')->name('moderator.companies.dashboard');
	Route::get('/dashboard/moderator/projects', 'AdminController@moderator_dashboard_projects')->name('moderator.projects.dashboard');
	Route::get('/search-companies', 'SearchController@moderator_filter_companies')->name('mod.filter.companies');
	//User Module
	Route::get('/manage/users', 'UserController@index')->name('admin.user.index');
	Route::get('/manage/users/create', 'UserController@create')->name('admin.user.create');
	Route::post('/manage/users/store', 'UserController@store')->name('admin.user.store');
	Route::get('/manage/users/edit/{user}', 'UserController@edit')->name('admin.user.edit');
	Route::post('/manage/users/update/{user}', 'UserController@update')->name('admin.user.update');
	Route::delete('/manage/users/delete/{user}', 'UserController@destroy')->name('admin.user.delete');
	Route::get('/manage/moderators', 'UserController@moderators')->name('admin.user.mods');
	Route::get('/manage/moderator-stat/{user}', 'UserController@moderator_stats')->name('admin.user.mod_stat');
	//Industries Module
	Route::get('/manage/industries', 'AdminController@industries')->name('admin.industries');
	Route::get('/manage/industries/create', 'IndustriesController@create')->name('admin.industry.create');
	Route::post('/manage/industries/store', 'IndustriesController@store')->name('admin.industry.store');
	Route::get('/manage/industries/{industry}/edit', 'IndustriesController@edit')->name('admin.industry.edit');
	Route::post('/manage/industries/{industry}/update', 'IndustriesController@update')->name('admin.industry.update');
	//Specialities Module
	Route::get('/manage/specialities', 'AdminController@specialities')->name('admin.specialities');
	Route::get('/manage/specialities/create', 'SpecialitiesController@create')->name('admin.speciality.create');
	Route::post('/manage/specialities/store', 'SpecialitiesController@store')->name('admin.speciality.store');
	Route::get('/manage/specialities/{speciality}/edit', 'SpecialitiesController@edit')->name('admin.speciality.edit');
	Route::post('/manage/specialities/{speciality}/update', 'SpecialitiesController@update')->name('admin.speciality.update');
	//Projects Module
	Route::get('/manage/projects', 'AdminController@projects')->name('admin.projects');
	Route::get('/manage/projects/{project}/edit', 'ProjectsController@admin_edit')->name('admin.project.edit');
	Route::post('/manage/projects/{project}/update', 'ProjectsController@admin_update')->name('admin.project.update');
	Route::post('/promote-project/{project}', 'ProjectsController@promote')->name('admin.project.promote');
	Route::post('/unpromote-project/{project}', 'ProjectsController@unpromote')->name('admin.project.unpromote');
	//Companies Module
	Route::get('/manage/companies', 'AdminController@companies')->name('admin.companies');
	Route::get('/manage/companies/create', 'CompaniesController@admin_create')->name('admin.company.create');
	Route::post('/manage/companies/store', 'CompaniesController@admin_store')->name('admin.company.store');
	Route::get('/manage/companies/{company}/edit', 'CompaniesController@admin_edit')->name('admin.company.edit');
	Route::post('/manage/companies/{company}/update', 'CompaniesController@admin_update')->name('admin.company.update');
	Route::post('/promote-company/{company}', 'CompaniesController@promote')->name('admin.company.promote');
	Route::post('/unpromote-company/{company}', 'CompaniesController@unpromote')->name('admin.company.unpromote');
	Route::post('/verify/{company}', 'CompaniesController@verify')->name('admin.company.verify');
	Route::post('/unverify/{company}', 'CompaniesController@unverify')->name('admin.company.unverify');
	Route::delete('/{company}/delete', 'CompaniesController@destroy')->name('admin.company.delete');
	Route::delete('/{company}/delete-reviews', 'CompaniesController@clear_reviews')->name('admin.company.delete-reviews');
	//Flagged Reviews
	//Route::get('/manage/reviews', 'AdminController@reviews')->name('admin.reviews');
	//Export / Import CSV
	Route::get('import-export-view', 'ExcelController@importExportView')->name('import.export.view');
	Route::post('import-file', 'ExcelController@importFile')->name('import.file');
	Route::get('export-file/{type}', 'ExcelController@exportFile')->name('export.file');
	Route::get('callcenter-reports', 'AdminController@admin_callcenter_reports')->name('callcenter.reports');
	Route::get('callcenter-details', 'AdminController@admin_callcenter_reports_details')->name('callcenter.reports.details');
});

Route::prefix('user')->group(function() {
	Route::get('/dashboard/{user}', 'UserController@dashboard')->name('front.user.dashboard');
	Route::get('/dashboard/{user}/myprojects', 'UserController@myprojects')->name('front.user.myprojects');
	Route::get('/dashboard/{user}/opportunities', 'UserController@opportunities')->name('front.user.opportunities');
	//Company Module
	Route::post('/company/store', ['middleware' => ['permission:create-company', 'role:user|superadmin'], 'uses' => 'CompaniesController@store'])->name('front.company.store');
	Route::get('/company/create', ['middleware' => ['permission:create-company', 'role:user|superadmin'], 'uses' => 'CompaniesController@create'])->name('front.company.create');
	Route::get('/messages/all', 'MessagesController@index')->name('front.messages.index');
	Route::get('/messages/{id}', 'MessagesController@show')->name('front.messages.show');
	Route::get('/bookmarks', 'BookmarksController@listBookmarks')->name('front.bookmarks.list');
	Route::get('/bookmarks/companies', 'BookmarksController@companiesBookmarks')->name('front.bookmarks.listcompanies');
	Route::get('/bookmarks/opportunities', 'BookmarksController@opportunitiesBookmarks')->name('front.bookmarks.listopportunities');
	//User Profile
	Route::get('/profile/{user}', 'UserController@profile')->name('front.user.profile');
	Route::get('/profile/{user}/edit', 'UserController@edit_profile_settings')->name('front.user.editprofile');
	Route::post('/profile/{user}/update_basic', 'UserController@update_basic_info')->name('front.user.update_basic');
	Route::get('/profile/{user}/edit_location', 'UserController@edit_location')->name('front.user.editlocation');
	Route::post('/profile/{user}/update_location', 'UserController@update_location')->name('front.user.update_location');
	Route::post('/profile/{user}/update_logo', 'UserController@update_logo')->name('front.user.update_logo');
	Route::get('/profile/{user}/reviews', 'UserController@reviews')->name('front.user.reviews');
	Route::get('/profile/{user}/supplierreviews', 'UserController@supplier_reviews')->name('front.user.supplierreviews');
	Route::get('/profile/{user}/customerreviews', 'UserController@customer_reviews')->name('front.user.customerreviews');
	Route::post('/profile/{user}/{review}/update', 'UserController@review_update')->name('front.user.review_update');
	Route::delete('/profile/{user}/{review}/delete', 'UserController@review_delete')->name('front.user.review_delete');
});	

Route::prefix('companies')->group(function() {
	Route::get('/all', 'CompaniesController@index')->name('front.company.all');
	Route::get('/{company}', 'CompaniesController@show')->name('front.company.show');
	Route::get('/{company}/edit', 'CompaniesController@edit')->name('front.company.edit');
	Route::post('/{company}/update', 'CompaniesController@update')->name('front.company.update');
	Route::post('/updatelogo/{company}', 'CompaniesController@update_logo')->name('front.company.updatelogo');
	Route::get('/industries/{industry}', 'CompaniesController@show_industry')->name('front.company.showindustry');
	Route::get('/claim/{company}', 'CompaniesController@claim_notification')->name('front.company.claim_notification');
	Route::get('/claim/form/{company}', 'CompaniesController@claim_application')->name('front.company.claim_application');
	Route::post('/claim/confirm/{company}', 'CompaniesController@claim')->name('front.company.claim');
	Route::get('/claim/thanks/{company}', 'CompaniesController@claim_thanks')->name('front.company.claim-thanks');
});


Route::prefix('industries')->group(function() {
	Route::get('/opportunities', 'IndustriesController@index')->name('front.industry.index');
	Route::get('/{industry}', 'IndustriesController@show')->name('front.industry.show');
});

Route::prefix('projects')->group(function() {
	Route::post('/store', ['uses' => 'ProjectsController@store'])->name('front.project.store');
	Route::get('/create', ['uses' => 'ProjectsController@create'])->name('front.project.create');
	Route::get('/{project}', 'ProjectsController@show')->name('front.project.show');
	Route::post('close/{project}', 'ProjectsController@close')->name('front.project.close');
	Route::post('publish/{project}', 'ProjectsController@publish')->name('front.project.publish');
	Route::get('edit/{project}', 'ProjectsController@edit')->name('front.project.edit');
	Route::post('/update/{project}', ['middleware' => ['permission:create-project', 'role:company|superadmin'], 'uses' => 'ProjectsController@update'])->name('front.project.update');
});


//Send Express Interest Request
Route::post('/interest/store', ['uses' => 'InterestsController@store'])->name('express.interest');

Route::delete('/interest/delete/{interest}', ['uses' => 'InterestsController@destroy'])->name('withdraw.interest');
Route::post('/interest/{interest}/accept', ['uses' => 'InterestsController@accept_interest'])->name('accept.interest');
Route::post('/interest/{interest}/decline', ['uses' => 'InterestsController@decline_interest'])->name('decline.interest');

Route::post('/review/customer', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@store_customer_review'])->name('add.review.customer');
Route::post('/review/supplier', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@store_supplier_review'])->name('add.review.supplier');
Route::post('/review/{review}/like', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@like'])->name('review.like');
Route::post('/review/{review}/unlike', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@unlike'])->name('review.unlike');
Route::post('/review/{review}/flag', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@flag'])->name('review.flag');
Route::delete('/review/{review}/unflag', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'ReviewsController@unflag'])->name('review.unflag');
Route::post('/reply/{reply}/like', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'RepliesController@like'])->name('reply.like');
Route::post('/reply/{reply}/unlike', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'RepliesController@unlike'])->name('reply.unlike');

Route::get('/search-opportunities', 'SearchController@filter_opportunities')->name('filter.opportunities');
Route::get('/search-companies', 'SearchController@filter_companies')->name('filter.companies');
Route::get('/search', 'SearchController@search')->name('search.all');
Route::post('/bookmark/add', 'BookmarksController@addBookmark')->name('bookmark.add');
Route::post('/bookmark/remove/{bookmark}', 'BookmarksController@removeBookmark')->name('bookmark.remove');
Route::post('/delete/{file}', ['uses' => 'MyFilesController@destroy'])->name('front.file.delete');
Route::get('/about', 'HomeController@about')->name('about');

Route::post('/reply', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'RepliesController@store'])->name('add.reply.toreview');
//Social Connect

Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','facebook|linkedin')->name('socialLogin');

Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','facebook|linkedin')->name('socialCallback');