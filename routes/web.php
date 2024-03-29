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

	$locale = Session::get('locale');

    if($locale) {
        app()->setLocale($locale);
    }
    $return_user = new App\ReturningUser;
    $ip = Request::ip();
    if(Auth::user()) {
        $Login_returning = $return_user->where('user_id', Auth::user()->id)->where('return_time', '>', Carbon\Carbon::now()->subDay(1)->toDateTimeString())->first();
    }
	if(Auth::user() && !$Login_returning) {
        $return_user->user_id = Auth::user()->id;
        $return_user->return_time = Carbon\Carbon::now()->toDateTimeString();
        $return_user->return_ip = $ip;
        $return_user->status = 'logged_in';
        $return_user->save();
    }

    if(Auth::user()) {
    	return redirect(route('front.user.dashboard', Auth::user()->username));
    }else {
    	return view('front.home');
    }
})->name('home');

Auth::routes();

Route::get('/language/{locale}', function ($locale) {
	$refer_url = URL::previous();

	if($locale == '') {
		App::setLocale('en');
		session(['locale' => 'en']);
	}else{
		App::setLocale($locale);
		session(['locale' => $locale]);
	}

	if(Auth::user()) {
		$user = Auth::user();
		$user->lang = $locale;
		$user->update();
	}

    return redirect()->to($refer_url);
})->name('change.lang');

Route::get('/status', 'HomeController@status');


//Dashboard for admins only
Route::prefix('admin')->middleware('role:superadmin|administrator|moderator')->group(function() {
	Route::get('/', 'AdminController@index');
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
	Route::get('/dashboard/moderator/companies', 'AdminController@moderator_dashboard_companies')->name('moderator.companies.dashboard');
	Route::get('/dashboard/moderator/mycompanies/{user}', 'AdminController@moderator_dashboard_mycompanies')->name('moderator.companies.mycompanies');
	Route::get('/dashboard/moderator/projects', 'AdminController@moderator_dashboard_projects')->name('moderator.projects.dashboard');
	Route::get('/search-companies', 'SearchController@moderator_filter_companies')->name('mod.filter.companies');
	Route::get('/search-companies/superadmin', 'SearchController@superadmin_filter_companies')->name('superadmin.filter.companies');
	Route::get('/search-users/superadmin', 'SearchController@superadmin_filter_users')->name('superadmin.filter.users');
	Route::get('/search-projects/superadmin', 'SearchController@superadmin_filter_projects')->name('superadmin.filter.projects');
	//User Module
	Route::get('/manage/users', 'UserController@index')->name('admin.user.index');
	Route::get('/manage/users/create', 'UserController@create')->name('admin.user.create');
	Route::post('/manage/users/store', 'UserController@store')->name('admin.user.store');
	Route::get('/manage/users/edit/{user}', 'UserController@edit')->name('admin.user.edit');
	Route::post('/manage/users/update/{user}', 'UserController@update')->name('admin.user.update');
	Route::delete('/manage/users/delete/{user}', 'UserController@destroy')->name('admin.user.delete');
	Route::get('/manage/moderators', 'UserController@moderators')->name('admin.user.mods');
	Route::get('/manage/moderator-stat/{user}', 'UserController@moderator_stats')->name('admin.user.mod_stat');
	Route::get('/manage/moderator-portfolio-track/{user}', 'UserController@mod_portfolio_track')->name('admin.user.mod_portfolio_track');
	Route::get('/manage/users/logins', 'UserController@logins')->name('admin.user.logins');
	Route::get('/manage/users/logins/{user}', 'UserController@user_logins')->name('admin.user.user-logins');
	Route::get('/manage/users/emails', 'UserController@emails')->name('admin.user.emails');
	Route::post('/manage/users/send-creds/{user}', 'AdminController@send_credentials_email')->name('admin.user.creds');
	//Industries Module
	Route::get('/manage/industries', 'AdminController@industries')->name('admin.industries');
	Route::get('/manage/industries/create', 'IndustriesController@create')->name('admin.industry.create');
	Route::post('/manage/industries/store', 'IndustriesController@store')->name('admin.industry.store');
	Route::get('/manage/industries/{industry}/edit', 'IndustriesController@edit')->name('admin.industry.edit');
	Route::post('/manage/industries/{industry}/update', 'IndustriesController@update')->name('admin.industry.update');
	Route::post('/manage/industries/disable/{industry}', 'IndustriesController@disable')->name('admin.industry.disable');
	Route::post('/manage/industries/enable/{industry}', 'IndustriesController@enable')->name('admin.industry.enable');
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
	Route::get('/manage/companies/{company}/activities', 'CompaniesController@company_activities')->name('admin.company.activity');
	Route::post('/promote-company/{company}', 'CompaniesController@promote')->name('admin.company.promote');
	Route::post('/unpromote-company/{company}', 'CompaniesController@unpromote')->name('admin.company.unpromote');
	Route::post('/verify/{company}', 'CompaniesController@verify')->name('admin.company.verify');
	Route::post('/unverify/{company}', 'CompaniesController@unverify')->name('admin.company.unverify');
	Route::delete('/{company}/delete', 'CompaniesController@destroy')->name('admin.company.delete');
	Route::delete('/{company}/delete-reviews', 'CompaniesController@clear_reviews')->name('admin.company.delete-reviews');
	Route::get('/manage/hidden-companies', 'AdminController@hidden_companies')->name('admin.hidden-companies');
	Route::get('/manage/companies/claims', 'AdminController@get_claims')->name('admin.get_claims');
	Route::get('/manage/companies/show-claim/{claim}', 'AdminController@show_claim')->name('admin.show_claim');
	Route::post('/manage/companies/accept-claim/{claim}/{company}', 'AdminController@accept_claim')->name('admin.accept_claim');
	Route::post('/manage/companies/decline-claim/{claim}/{company}', 'AdminController@decline_claim')->name('admin.decline_claim');
	//Flagged Reviews
	//Route::get('/manage/reviews', 'AdminController@reviews')->name('admin.reviews');
	//Export / Import CSV
	Route::get('import-export-view', 'ExcelController@importExportView')->name('import.export.view');
	Route::post('import-file', 'ExcelController@importFile')->name('import.file');
	Route::get('export-file/{type}', 'ExcelController@exportFile')->name('export.file');
	Route::get('callcenter-reports', 'AdminController@admin_callcenter_reports')->name('callcenter.reports');
	Route::get('callcenter-details', 'AdminController@admin_callcenter_reports_details')->name('callcenter.reports.details');
	//Translation
	Route::get('/manage/translations', '\Barryvdh\TranslationManager\Controller@getIndex')->name('admin.translation');
	//Settings
	Route::get('/manage/settings', 'AdminController@settings')->name('admin.settings');
	Route::post('/manage/add-setting', 'AdminController@add_setting')->name('admin.add-setting');
	Route::post('/manage/update-setting/{setting}', 'AdminController@update_setting')->name('admin.update-setting');
	//EndSettings
	Route::get('/returning-users', 'AdminController@returning_users')->name('admin.returning-users');
});

Route::prefix('user')->group(function() {
	Route::get('/dashboard/{user}', 'UserController@dashboard')->name('front.user.dashboard');
	Route::get('/dashboard/{user}/myprojects', 'UserController@myprojects')->name('front.user.myprojects');
	Route::get('/dashboard/{user}/opportunities', 'UserController@opportunities')->name('front.user.opportunities');
	Route::get('/dashboard/{user}/project-interests/{project}', 'UserController@project_interests')->name('front.user.project-interests');
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
	//Portfolio
	Route::post('/add-portfolio/{company}', 'PortfoliosController@store')->name('front.portfolio.store');
	Route::post('/delete-portfolio/{company}/{portfolio}', 'PortfoliosController@destroy')->name('front.portfolio.delete');
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
Route::post('/interest/{interest}/undo', ['uses' => 'InterestsController@undo_interest'])->name('undo.interest');

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
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy');
Route::get('/our-team', 'HomeController@our_team')->name('team');

Route::post('/reply', ['middleware' => ['role:user|company|superadmin'], 'uses' => 'RepliesController@store'])->name('add.reply.toreview');
//Social Connect

Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','facebook|linkedin')->name('socialLogin');

Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','facebook|linkedin')->name('socialCallback');
Route::post('/subscribe', 'HomeController@subscribe')->name('subscribe');
Route::post('/unsubscribe', 'HomeController@unsubscribe')->name('unsubscribe');
Route::post('request-company-info/{company}', 'CompaniesController@request_info')->name('company-request-info');