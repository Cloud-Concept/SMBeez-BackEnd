<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Review;
use App\Interest;
use App\Claim;
use App\Bookmark;
use App\Project;
use App\Company;
use App\Industry;
use App\Speciality;
use App\Message;
use App\ModLog;
use App\EmailLogs;
use App\ModCompanyReport;
use App\CsmTracking;
use Illuminate\Pagination\LengthAwarePaginator;
use \App\Repositories\ProjectFunctions;
use Carbon\Carbon;
use App\UserLogins;
use App\Setting;
use Image;
use File;
use DB;
use Auth;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::orderBy('id', 'asc')->with('roles')->paginate(50);
        return view('admin.users.index', compact('users'));
    }

    public function logins(Request $request)
    {   
        if($request['date_from'] || $request['date_to']) {
            $get_logins = UserLogins::whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->get();
        }else{
            $get_logins = UserLogins::latest()->get();
        }

        $users = array();
        foreach($get_logins as $login) {
            $users[] = $login->user_id;
        }
        $users = User::whereIn('id', $users)->get();

        $lists = array();

        foreach($users as $u) {
            if($request['date_from'] || $request['date_to']) {
                $logins_count = UserLogins::where('user_id', $u->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
            }else{
                $logins_count = UserLogins::where('user_id', $u->id)->count();
            }
            array_push($lists, array(
                'user' => $u,
                'logins' => $logins_count
            ));
        }

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($lists);
 
        // Define how many items we want to be visible in each page
        $perPage = 50;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        $lists = $paginatedItems;

        //dd($lists[0]['user']->email);
        return view('admin.users.logins', compact('users', 'lists'));
    }
    public function user_logins(User $user, Request $request)
    {   
        $logins = UserLogins::where('user_id', $user->id)->latest()->paginate(50);
        return view('admin.users.login-details', compact('logins'));
    }
    public function emails(Request $request)
    {   
        if($request['date_from'] || $request['date_to']) {
            $emails = EmailLogs::whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->paginate(10);
        }else{
            $emails = EmailLogs::latest()->paginate(50);
        }

        return view('admin.users.emails', compact('emails'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        /*$this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);*/

        $user = new User;
        
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->user_city = $request['user_city'];
        $user->honeycombs = 0;

        $user->save();

        $user->roles()->sync(request('role'), false);

        $sluggable = $user->replicate();

        if($user->save()) {
            session()->flash('success', 'User has been added');
            return redirect()->route('admin.user.edit', $user->username);
        }else {
            session()->flash('error', 'Sorry, an error occured while creating the user.');
            return redirect()->withErrors($request->getErrors())->route('admin.user.create');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $roles = Role::all();
        $last_login = UserLogins::where('user_id', $user->id)->latest()->first();
        //get the user interests
        $interests = $user->interests->modelKeys();
        $project = new Project;
        //find the interested projects where the user id is the user_id in the interests table
        $interested_projects = $project->whereHas('interests', function ($q) use ($interests) {
            $q->whereIn('interests.id', $interests);
        })->where('id', '<>', $user->id)->get();
        return view('admin.users.edit', compact('user', 'roles', 'last_login', 'interested_projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];

        if($request->hasFile('profile_pic_url')) {

            $profile_pic_url     = $request->file('profile_pic_url');
            $img_name  = time() . '.' . $profile_pic_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/users/';
            //path of the new image
            $path       = public_path('images/users/' . $img_name);
            //save image to the path
            Image::make($profile_pic_url)->resize(48, 48)->save($path);
            //get the old image
            $oldImage = $user->profile_pic_url;
            //make the field profile_pic_url in the table = to the link of img
            $user->profile_pic_url = $path_db . $img_name;
            //delete the old image
            File::delete(public_path($oldImage));
        }

        //update it to the database
        if(!empty($request['password'])){
            $user->password = bcrypt($request['password']);
        }

        $user->update();

        $user->roles()->sync(request('role'), true);

        if($user->update()) {
            session()->flash('success', 'User has been updated');
        }else {
            session()->flash('error', 'Sorry, an error occured while editing the user.');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        //delete from pviot table
        $user->roles()->detach();
        //remove the attached image from the folder
        File::delete(public_path($user->profile_pic_url));

        $hasCompany = Company::where('user_id', $user->id)->first();
        if($hasCompany) {
            //delete company
            $user->company->delete();
            //delete specialities
            $user->company->specialities()->detach();
            //delete reviews
            $company_reviews = Review::where('company_id', $user->company->id)->get();
            foreach($company_reviews as $review) {
                $review->delete();
                foreach($review->replies as $reply) {
                    $reply->delete();
                }
            }
            
            //delete claims
            $company_claims = Claim::where('company_id', $user->company->id)->get();
            foreach($company_claims as $claim){
                $claim->delete();
            }
            //delete bookmarks
            $company_bookmarks = Bookmark::where('bookmarked_id', $user->company->id)
            ->where('bookmark_type', 'App\Company')->get();
            foreach($company_bookmarks as $bookmark) {
                $bookmark->delete();
            }
            //delete company projects
            //get projects ids
            $company_projects_ids = Project::where('company_id', $user->company->id)->pluck('id');
            $company_projects_bookmarks = Bookmark::whereIn('bookmarked_id', $company_projects_ids)
            ->where('bookmark_type', 'App\Project')->get();
            foreach($company_projects_bookmarks as $project_bookmark) {
                $project_bookmark->delete();
            }
            //delete interests
            $company_projects_interests = Interest::where('user_id', $company->user->id)->get();

            foreach($company_projects_interests as $interest) {
                $interest->delete();
            }
            $company_projects = Project::where('company_id', $user->company->id)->get();
            foreach($company_projects as $project) {
                $project->delete();
                $project->specialities()->detach();
            }

            //remove the attached image from the folder
            File::delete(public_path($user->company->logo_url));
            File::delete(public_path($user->company->cover_url));
            File::delete(public_path($user->company->reg_doc));
        }

        session()->flash('success', 'User has been deleted');

        return redirect(route('admin.user.index'));
    }
    // Front End Stuff

    public function dashboard(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the dashboard 
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            $user = auth()->user();

            $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->take(3)->get();
            //get the user interests
            $interests = $user->interests->modelKeys();
            $company = new Company;
            $hascompany = $company->where('user_id', Auth::id())->first();

            $project = new Project;
            //find the interested projects where the user id is the user_id in the interests table
            $interested_projects = $project->whereHas('interests', function ($q) use ($interests) {
                $q->whereIn('interests.id', $interests);
            })->where('id', '<>', $user->id)->get();

            $industries = new Industry;
            if ($hascompany) {
                $industries = $industries->whereIn('display', ['projects', 'both'])->orderBy('industry_name')->get();
            }else{
                $industries = $industries->whereIn('display', ['companies', 'both'])->orderBy('industry_name')->get();
            }
            $speciality = new Speciality;
            $specialities = $speciality->all();
            $setting = new Setting;

            return view('front.users.dashboard', compact('user_messages','user', 'hascompany','interested_projects', 'industries', 'specialities', 'setting'));

        }
    }


    public function profile(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the dashboard 
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            if($user->company) {
                
                $customer_reviews = $user->company->reviews->where('company_id', $user->company->id)
                ->where('reviewer_relation', 'customer');

                $suppliers_reviews = $user->company->reviews->where('company_id', $user->company->id)
                ->where('reviewer_relation', 'supplier');

            }

            return view('front.users.profile', compact('user', 'customer_reviews', 'suppliers_reviews'));

        }
    }

    public function edit_profile_settings(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            return view('front.users.settings.basic-info', compact('user'));

        }
    }

    public function update_basic_info(Request $request, User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];

            if($request->hasFile('profile_pic_url')) {

                $profile_pic_url     = $request->file('profile_pic_url');
                $img_name  = time() . '.' . $profile_pic_url->getClientOriginalExtension();
                //path to year/month folder
                $path_db = 'images/users/';
                //path of the new image
                $path       = public_path('images/users/' . $img_name);
                //save image to the path
                Image::make($profile_pic_url)->resize(48, 48)->save($path);
                //get the old image
                $oldImage = $user->profile_pic_url;
                //make the field profile_pic_url in the table = to the link of img
                $user->profile_pic_url = $path_db . $img_name;
                //delete the old image
                File::delete(public_path($oldImage));
            }

            //update it to the database
            if(!empty($request['password'])){
                $user->password = bcrypt($request['password']);
            }

            $user->update();

            if($user->update()) {
                session()->flash('success', 'تم تحديث بيانات ملفك الشخصي.');
            }else {
                session()->flash('success', 'نأسف! لقد حدث خطأ برجاء المحاولة لاحقاً.');
            }

            return redirect(route('front.user.profile', $user->username));

        }
    }


    public function edit_location(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            return view('front.users.settings.location', compact('user'));

        }
    }

    public function update_location(Request $request, User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            $user->user_city = $request['user_city'];

            $user->update();

            if($user->update()) {
                session()->flash('success', 'تم تحديث بيانات ملفك الشخصي.');
            }else {
                session()->flash('success', 'نأسف! لقد حدث خطأ برجاء المحاولة لاحقاً.');
            }
            return redirect(route('front.user.profile', $user->username));

        }
    }

    public function reviews(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $user_reviews = $user->reviews()->paginate(3);
            return view('front.users.settings.reviews', compact('user', 'user_reviews'));

        }
    }

    public function supplier_reviews(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $user_reviews = $user->reviews()->where('reviewer_relation', 'supplier')->paginate(3);
            return view('front.users.settings.reviews', compact('user', 'user_reviews'));

        }
    }

    public function customer_reviews(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $user_reviews = $user->reviews()->where('reviewer_relation', 'customer')->paginate(3);
            return view('front.users.settings.reviews', compact('user', 'user_reviews'));

        }
    }

    public function review_update(Request $request, User $user, Review $review)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $review->feedback = $request['feedback'];
            $review->update();

            if($review->update()) {
                session()->flash('success', 'تم تحديث تقييمك.');
            }else {
                session()->flash('error', 'عفواً! حدث خطأ ما برجاء المحاولة لاحقاً.');
            }

            return back();

        }
    }


    public function review_delete(Request $request, User $user, Review $review)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $review->delete();

            foreach($review->replies as $reply) {
                $reply->delete();
            }
            session()->flash('success', 'تم مسح تقييمك.');
            return back();

        }
    }

    public function update_logo(Request $request, User $user)
    {
        if($request->hasFile('profile_pic_url')) {

            $profile_pic_url     = $request->file('profile_pic_url');
            $img_name  = time() . '.' . $profile_pic_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/users/';
            //path of the new image
            $path       = public_path('images/users/' . $img_name);
            //save image to the path
            Image::make($profile_pic_url)->resize(48, 48)->save($path);
            //get the old image
            $oldImage = $user->profile_pic_url;
            //make the field profile_pic_url in the table = to the link of img
            $user->profile_pic_url = $path_db . $img_name;
            //delete the old image
            File::delete(public_path($oldImage));
        }

        $user->update();
        session()->flash('success', 'تم تحديث صورة ملفك الشخصي.');
        return back();
    }
    public function myprojects(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {

            $user = auth()->user();

            $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->take(3)->get();

            $project = new Project;
            $industry = new Industry;

            $suggested_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $user_company = auth()->user()->company;
                $q->where('industries.id', $user_company->industry->id);
            })
            ->whereDoesntHave('interests', function ($query) {
                $user = auth()->user();
                $query->where('user_id', $user->id);
            })
            ->where('is_promoted', 1)
            ->where('status', 'publish')
            ->where('user_id', '!=', $user->id)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

            $industries = new Industry;
            $industries = $industries->orderBy('industry_name')->get();
            $speciality = new Speciality;
            $specialities = $speciality->all();
            $setting = new Setting;
            return view('front.users.myprojects', compact('user_messages','user', 'suggested_projects', 'industries', 'specialities', 'setting'));
        }
    }

    public function opportunities(User $user)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {

            $user = auth()->user();

            $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->take(3)->get();

            $project = new Project;
            $industry = new Industry;

            $suggested_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $user_company = auth()->user()->company;
                $q->where('industries.id', $user_company->industry->id);
            })
            ->whereDoesntHave('interests', function ($query) {
                $user = auth()->user();
                $query->where('user_id', $user->id);
            })
            ->where('is_promoted', 1)
            ->where('status', 'publish')
            ->where('user_id', '!=', $user->id)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();


            $interests = $user->interests->modelKeys();
            //find the interested projects where the user id is the user_id in the interests table
            $interested_projects = $project->whereHas('interests', function ($q) use ($interests) {
                $q->whereIn('interests.id', $interests);
            })->where('id', '<>', $user->id)->get();

            $industries = new Industry;
            $industries = $industries->orderBy('industry_name')->get();
            $speciality = new Speciality;
            $specialities = $speciality->all();
            $setting = new Setting;
            return view('front.users.opportunities', compact('user_messages','user', 'suggested_projects', 'interested_projects', 'industries', 'specialities', 'setting'));
        }
    }

    public function project_interests(User $user, Project $project)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {
            $user = auth()->user();
            $interests = $project->interests->where('is_accepted', '===', null);
            $approved_interests = $project->interests->where('is_accepted', '===', 1);
            $rejected_interests = $project->interests->where('is_accepted', '===', 0);
            $rejection_reasons = array(trans('general.rejection_reason1'), trans('general.rejection_reason2'), trans('general.rejection_reason3'), trans('general.rejection_reason4'), trans('general.rejection_reason5'), trans('general.rejection_reason6'));
            $setting = new Setting;
            return view('front.users.project-interests', compact('user', 'project', 'interests', 'approved_interests', 'rejected_interests', 'rejection_reasons', 'setting'));
        }
    }

    public function moderators() {
        $user = auth()->user();
        if(!$user->hasRole(['superadmin'])) {
            return redirect()->route('home');
        }

        $moderators = User::whereHas('roles', function($q){
            $q->where('name', 'moderator');
        })->get();

        return view('admin.users.moderator-list', compact('moderators'));
    }

    public function moderator_stats(User $user, Request $request) {
        $_user = auth()->user();
        if(!$_user->hasRole(['superadmin'])) {
            return redirect()->route('home');
        }

        $log = new ModLog;
        $report = new ModCompanyReport;

        $today_company_updates = $log->where('activity_type', 'company_update')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_report_creates = $log->where('activity_type', 'report_create')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_assign_users = $log->where('activity_type', 'assign_user')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_assign_new_user = $log->where('activity_type', 'assign_new_user')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_message_sent = $log->where('activity_type', 'message_sent')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_companies_by_users = $log->where('activity_type', 'new_user_created_company')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_companies_imported_admin = $log->where('activity_type', 'admin_created_company')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_interested_calls = $report->where('status', 'Successful Call - Interested')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_notinterested_calls = $report->where('status', 'Successful Call - Not Interested')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_callback_calls = $report->where('status', 'Successful Call - Agreed to Call Back')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_msgdetails_calls = $report->where('status', 'Successful Call - Asked for more details via email')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        
        $today_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_unreachable_calls = $report->where('status', 'Unsuccessful Call - Unreachable')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_wrongno_calls = $report->where('status', 'Unsuccessful Call - Wrong number')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
        $today_noanswer_calls = $report->where('status', 'Unsuccessful Call - No answer')->where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();

        $overall_company_updates = $log->where('activity_type', 'company_update')->where('user_id', $user->id)->count();
        $overall_report_creates = $log->where('activity_type', 'report_create')->where('user_id', $user->id)->count();
        $overall_assign_users = $log->where('activity_type', 'assign_user')->where('user_id', $user->id)->count();
        $overall_assign_new_user = $log->where('activity_type', 'assign_new_user')->where('user_id', $user->id)->count();
        $overall_message_sent = $log->where('activity_type', 'message_sent')->where('user_id', $user->id)->count();
        $overall_companies_by_users = $log->where('activity_type', 'new_user_created_company')->where('user_id', $user->id)->count();
        $overall_companies_imported_admin = $log->where('activity_type', 'admin_created_company')->where('user_id', $user->id)->count();
        $overall_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->where('user_id', $user->id)->count();
        $overall_interested_calls = $report->where('status', 'Successful Call - Interested')->where('user_id', $user->id)->count();
        $overall_notinterested_calls = $report->where('status', 'Successful Call - Not Interested')->where('user_id', $user->id)->count();
        $overall_callback_calls = $report->where('status', 'Successful Call - Agreed to Call Back')->where('user_id', $user->id)->count();
        $overall_msgdetails_calls = $report->where('status', 'Successful Call - Asked for more details via email')->where('user_id', $user->id)->count();
        $overall_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->where('user_id', $user->id)->count();
        $overall_unreachable_calls = $report->where('status', 'Unsuccessful Call - Unreachable')->where('user_id', $user->id)->count();
        $overall_wrongno_calls = $report->where('status', 'Unsuccessful Call - Wrong number')->where('user_id', $user->id)->count();
        $overall_noanswer_calls = $report->where('status', 'Unsuccessful Call - No answer')->where('user_id', $user->id)->count();

        $range_company_updates = $log->where('activity_type', 'company_update')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_report_creates = $log->where('activity_type', 'report_create')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_assign_users = $log->where('activity_type', 'assign_user')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_assign_new_user = $log->where('activity_type', 'assign_new_user')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_message_sent = $log->where('activity_type', 'message_sent')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_companies_by_users = $log->where('activity_type', 'new_user_created_company')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_companies_imported_admin = $log->where('activity_type', 'admin_created_company')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_interested_calls = $report->where('status', 'Successful Call - Interested')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_notinterested_calls = $report->where('status', 'Successful Call - Not Interested')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_callback_calls = $report->where('status', 'Successful Call - Agreed to Call Back')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_msgdetails_calls = $report->where('status', 'Successful Call - Asked for more details via email')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_unreachable_calls = $report->where('status', 'Unsuccessful Call - Unreachable')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_wrongno_calls = $report->where('status', 'Unsuccessful Call - Wrong number')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_noanswer_calls = $report->where('status', 'Unsuccessful Call - No answer')->where('user_id', $user->id)->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();

        $logs = array();

        array_push($logs, array(
            'today_company_updates' => $today_company_updates,
            'today_report_creates' => $today_report_creates,
            'today_assign_users' => $today_assign_users,
            'today_assign_new_user' => $today_assign_new_user,
            'today_message_sent' => $today_message_sent,
            'today_companies_by_users' => $today_companies_by_users,
            'today_companies_imported_admin' => $today_companies_imported_admin,
            'today_successful_calls' => $today_successful_calls,
            'today_unsuccessful_calls' => $today_unsuccessful_calls,
            'today_interested_calls' => $today_interested_calls,
            'today_notinterested_calls' => $today_notinterested_calls,
            'today_callback_calls' => $today_callback_calls,
            'today_msgdetails_calls' => $today_msgdetails_calls,
            'today_unreachable_calls' => $today_unreachable_calls,
            'today_wrongno_calls' => $today_wrongno_calls,
            'today_noanswer_calls' => $today_noanswer_calls,
            'overall_company_updates' => $overall_company_updates,
            'overall_report_creates' => $overall_report_creates,
            'overall_assign_users' => $overall_assign_users,
            'overall_assign_new_user' => $overall_assign_new_user,
            'overall_message_sent' => $overall_message_sent,
            'overall_companies_by_users' => $overall_companies_by_users,
            'overall_companies_imported_admin' => $overall_companies_imported_admin,
            'overall_successful_calls' => $overall_successful_calls,
            'overall_unsuccessful_calls' => $overall_unsuccessful_calls,
            'overall_interested_calls' => $overall_interested_calls,
            'overall_notinterested_calls' => $overall_notinterested_calls,
            'overall_callback_calls' => $overall_callback_calls,
            'overall_msgdetails_calls' => $overall_msgdetails_calls,
            'overall_unreachable_calls' => $overall_unreachable_calls,
            'overall_wrongno_calls' => $overall_wrongno_calls,
            'overall_noanswer_calls' => $overall_noanswer_calls,
            'range_company_updates' => $range_company_updates,
            'range_report_creates' => $range_report_creates,
            'range_assign_users' => $range_assign_users,
            'range_assign_new_user' => $range_assign_new_user,
            'range_message_sent' => $range_message_sent,
            'range_companies_by_users' => $range_companies_by_users,
            'range_companies_imported_admin' => $range_companies_imported_admin,
            'range_successful_calls' => $range_successful_calls,
            'range_unsuccessful_calls' => $range_unsuccessful_calls,
            'range_interested_calls' => $range_interested_calls,
            'range_notinterested_calls' => $range_notinterested_calls,
            'range_callback_calls' => $range_callback_calls,
            'range_msgdetails_calls' => $range_msgdetails_calls,
            'range_unreachable_calls' => $range_unreachable_calls,
            'range_wrongno_calls' => $range_wrongno_calls,
            'range_noanswer_calls' => $range_noanswer_calls,
        ));
        $logs = $logs[0];

        return view('admin.users.moderator-stat', compact('logs', 'user'));
    }

    public function mod_portfolio_track(User $user, Request $request) {
        $csm_companies = CsmTracking::where('user_id', $user->id)->latest()->paginate(50);
        $count = new ProjectFunctions;

        if($request['date_from'] || $request['date_to']) {
            $get_companies = CsmTracking::whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->get();
        }else{
            $get_companies = CsmTracking::latest()->get();
        }

        $companies = array();
        foreach($get_companies as $company) {
            $companies[] = $company->company_id;
        }
        $companies = Company::whereIn('id', $companies)->where('manager_id', $user->id)->get();

        $lists = array();

        foreach($companies as $u) {
            if($request['date_from'] || $request['date_to']) {
                $projects_count = CsmTracking::where('company_id', $u->id)->where('activity_type', 'published_project')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
                $express_interest = CsmTracking::where('company_id', $u->id)->where('activity_type', 'express_interest')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
                $accept_interest = CsmTracking::where('company_id', $u->id)->where('activity_type', 'accept_interest')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
                $decline_interest = CsmTracking::where('company_id', $u->id)->where('activity_type', 'decline_interest')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
                $customer_reviews = CsmTracking::where('company_id', $u->id)->where('activity_type', 'submit_customer_review')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
                $supplier_reviews = CsmTracking::where('company_id', $u->id)->where('activity_type', 'submit_supplier_review')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
            }else{
                $projects_count = CsmTracking::where('company_id', $u->id)->where('activity_type', 'published_project')->count();
                $express_interest = CsmTracking::where('company_id', $u->id)->where('activity_type', 'express_interest')->count();
                $accept_interest = CsmTracking::where('company_id', $u->id)->where('activity_type', 'accept_interest')->count();
                $decline_interest = CsmTracking::where('company_id', $u->id)->where('activity_type', 'decline_interest')->count();
                $customer_reviews = CsmTracking::where('company_id', $u->id)->where('activity_type', 'submit_customer_review')->count();
                $supplier_reviews = CsmTracking::where('company_id', $u->id)->where('activity_type', 'submit_supplier_review')->count();
            }
            array_push($lists, array(
                'company' => $u,
                'projects_count' => $projects_count,
                'express_interest' => $express_interest,
                'accept_interest' => $accept_interest,
                'decline_interest' => $decline_interest,
                'customer_reviews' => $customer_reviews,
                'supplier_reviews' => $supplier_reviews
            ));
        }

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($lists);
 
        // Define how many items we want to be visible in each page
        $perPage = 50;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        $lists = $paginatedItems;

        return view('admin.users.moderator-track', compact('companies', 'lists'));
    }
    
}
