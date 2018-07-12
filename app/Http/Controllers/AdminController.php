<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Review;
use App\Project;
use App\Industry;
use App\Speciality;
use App\Claim;
use App\ModCompanyReport;
use App\ModLog;
use Mail;
use App\Mail\Mod\Welcome;
use App\Mail\Mod\NewUser;
use Carbon\Carbon;

class AdminController extends Controller
{   
    public $old_profile_relevance_score = 0;
    public $specialities_count_before = 0;
	//redirect to admin dashboard
    public function index()
    {   
        $user = auth()->user();

        if(!$user->hasRole(['superadmin', 'administrator'])) {
            return redirect()->route('home');
        }

        return redirect()->route('admin.dashboard');
    }
    //view admin dashboard
    public function dashboard()
    {   
        $user = auth()->user();

        if(!$user->hasRole(['superadmin', 'administrator'])) {
            return redirect()->route('home');
        }

        $users = User::count();
        $companies = Company::with('users')->count();
        $customer_reviews = Review::with('companies')->where('reviewer_relation', 'customer')->count();
        $supplier_reviews = Review::with('companies')->where('reviewer_relation', 'supplier')->count();
        $projects = Project::with('users')->count();
        $completed_projects = Project::with('users')->where('status', 'closed')->count();
        $industries = Industry::with('projects')->count();
        $specialities = Speciality::with('project')->count();

        return view('admin.dashboard', compact('users', 'companies', 'customer_reviews', 'supplier_reviews', 'projects', 'completed_projects', 'industries', 'specialities'));
    }


    public function moderator_dashboard_companies()
    {   
        $user = auth()->user();

        if(!$user->hasRole(['moderator'])) {
            return redirect()->route('home');
        }
        $companies = Company::latest()->paginate(10);
        $industries = Industry::with('companies')->orderBy('industry_name', 'asc')->paginate(10);
        $status_array = array(
            '',
            'In Queue', 'Successful Call - Interested', 'Successful Call - Not Interested',
            'Successful Call - Agreed to Call Back', 'Successful Call - Asked for more details via email',
            'Unsuccessful Call - Unreachable', 'Unsuccessful Call - Wrong number',
            'Unsuccessful Call - No answer'
        );

        return view('admin.moderator-dashboard-companies', compact('companies', 'industries', 'status_array'));
    }

    public function moderator_dashboard_projects()
    {   
        $user = auth()->user();

        if(!$user->hasRole(['moderator'])) {
            return redirect()->route('home');
        }
        $projects = Project::paginate(10);

        return view('admin.moderator-dashboard-projects', compact('projects'));
    }
    //API
    public function get_company(Company $company, User $user)
    {   
        return response()->json($company->with('user')->where('id', $company->id)->first());
    }

    public function update_company(Request $request, Company $company) {

        $old_profile_relevance_score = $this->old_profile_relevance_score;

        $old_profile_completion = array($company->company_description, $company->linkedin_url, $company->company_website,
        $company->company_phone, $company->location, $company->company_email, $company->company_size,
        $company->company_tagline, $company->year_founded, $company->reg_number, $company->reg_doc);

        $old_profile_relevance_score += count(array_filter($old_profile_completion));

        $company->company_name = $request['company_name'];
        $company->company_email = $request['company_email'];
        $company->company_phone = $request['company_phone'];
        $company->location = $request['location'];

        $specialities_count_before = $this->specialities_count_before;
        $specialities_count_before += $company->specialities()->count();

        $company->update();

        $specs = explode(',', $request['hidden-speciality_id']);
        //check for specs that already exists in database
        $spec_exists = Speciality::with('companies')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
        //foreach specs add the specialities that is not recorded in the database
        foreach($specs as $spec) {
            $speciality = new Speciality;
            if(!in_array($spec, $spec_exists)) {
                if(!empty($spec)) {
                    $speciality->speciality_name = $spec;
                    $speciality->save();
                }
            }
        }
        //get ids of specialities to attach to the project
        $specs_ids = $speciality->with('companies')->whereIn('speciality_name', $specs)->pluck('id')->toArray();
        //sync project specialities
        $company->specialities()->sync($specs_ids, true);

        //if company have specialities
        if($specialities_count_before == 0 && $company->specialities()->count() > 0) {
            $company->addRelevanceScore(5, $company->id);
        }

        //relevance scoring
        $profile_completion = array($company->company_description, $company->linkedin_url, $company->company_website,
        $company->company_phone, $company->location, $company->company_email, $company->company_size,
        $company->company_tagline, $company->year_founded, $company->reg_number, $company->reg_doc);

        $current = count(array_filter($profile_completion));
        $current_score = $company->relevance_score;        
        if($company->user_id != 0) {
            $value = $current_score + ($current - $old_profile_relevance_score);
            $company->update(['relevance_score' => $value]);
        }
        //Logging
        $log = new ModLog;
        $mod_user = $request['mod_user'];
        $log->company_id = $company->id;
        $log->activity_type = 'company_update';
        $log->activity_log = 'Company "' . $company->company_name . '" has been updated.';
        $log->user_id = $mod_user;

        $log->save();

        return response()->json(['success' => 'Saved Successfully!']);
    }

    public function assign_company_to_user(Request $request, Company $company) {
        $user = User::where('email', $request['user_email'])->first();
        if(!$user->company) {
            $company->user_id = $user->id;
            $company->is_verified = 1;

            $company->update();

            $user->roles()->sync(3);

            Mail::to($request['user_email'])->send(new Welcome($company));
            
            //Logging
            $log = new ModLog;
            $mod_user = $request['mod_user'];
            $log->user_id = $mod_user;
            $log->company_id = $company->id;
            $log->activity_type = 'assign_user';
            $log->activity_log = 'Company "' . $company->company_name . '" has been assigned to existing user ' . $user->email;

            $log->save();

            return response()->json(['success' => 'Company Assigned Successfully!']);
        }elseif($user->company->id == $company->id){
            return response()->json(['success' => 'User Already Assigned to this company.']);
        }elseif($user->company->id != $company->id) {
            return response()->json(['success' => 'User Already Have Company']);
        }else{
            return response()->json(['success' => 'User Can\'t be assigned to a company.']);
        }
    }

    public function create_user_to_company(Request $request, Company $company) {
        if(!$company->user){

            $user = new User;
            
            $unique_password = uniqid();

            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->password = bcrypt($unique_password);
            $user->user_city = $company->city;
            $user->honeycombs = 0;

            $user->save();

            $user->roles()->sync(3, false);

            $sluggable = $user->replicate();
            //update the company
            $company->user_id = $user->id;
            $company->is_verified = 1;
            $company->role = $request['role'];

            $company->update();

            Mail::to($user->email)->send(new NewUser($user, $unique_password));
            //Logging
            $log = new ModLog;
            $mod_user = $request['mod_user'];
            $log->user_id = $mod_user;
            $log->company_id = $company->id;
            $log->activity_type = 'assign_new_user';
            $log->activity_log = 'Company "' . $company->company_name . '" has been assigned to a new user ' . $user->email;

            $log->save();

            return response()->json(['msg' => 'User Created Successfully!', 'data' => 'An email will be sent to the user to complete the login process.']);

        }else {
            return response()->json(['msg' => 'Company Already assigned to a user!', 'data' => '']);
        }
    }

    public function get_company_report(Company $company) {

        if($company->mod_report) {
            return response()->json($company->mod_report);
        }else {
            return response()->json(['msg' => 'Add New Status Report']);
        }
    }

    public function create_update_company_report(Request $request, Company $company) {

        if($company->mod_report) {
            $report = $company->mod_report;

            $report->status = $request['status'];
            $report->feedback = $request['feedback'];
            $report->company_id = $company->id;

            $report->update();

            //Logging
            $log = new ModLog;
            $mod_user = $request['mod_user'];
            $log->user_id = $mod_user;
            $log->company_id = $company->id;
            $log->activity_type = 'report_update';
            $log->activity_log = 'Company status updated to "' . $report->status . '"';

            $log->save();

            return response()->json(['msg' => 'Updated Successfully!', 'status' => $report->status]);

        }else {
            $report = new ModCompanyReport;
            $mod_user = $request['mod_user'];

            $report->user_id = $mod_user;
            $report->status = $request['status'];
            $report->feedback = $request['feedback'];
            $report->company_id = $company->id;

            $report->save();

            //Logging
            $log = new ModLog;
            
            $log->user_id = $mod_user;
            $log->company_id = $company->id;
            $log->activity_type = 'report_create';
            $log->activity_log = 'Company first call status is "' . $report->status . '"';

            $log->save();

            return response()->json(['msg' => 'Saved Successfully!', 'status' => $report->status]);
        }
    }

    public function send_mod_message(Request $request, Company $company) {

        Mail::to($request['user_email'])->send(new Welcome($company));

        //Logging
        $log = new ModLog;
        $mod_user = $request['mod_user'];
        $log->user_id = $mod_user;
        $log->company_id = $company->id;
        $log->activity_type = 'message_sent';
        $log->activity_log = 'A mail has been sent to company "' . $company->company_name . '"';

        $log->save();

        return response()->json(['msg' => 'Message Sent Successfully!']);
    }
    
    public function admin_callcenter_reports(Request $request, ModLog $log, ModCompanyReport $report) {

        $today_company_updates = $log->where('activity_type', 'company_update')->whereDate('created_at', Carbon::today())->count();
        $today_report_creates = $log->where('activity_type', 'report_create')->whereDate('created_at', Carbon::today())->count();
        $today_assign_users = $log->where('activity_type', 'assign_user')->whereDate('created_at', Carbon::today())->count();
        $today_assign_new_user = $log->where('activity_type', 'assign_new_user')->whereDate('created_at', Carbon::today())->count();
        $today_message_sent = $log->where('activity_type', 'message_sent')->whereDate('created_at', Carbon::today())->count();
        $today_companies_by_users = $log->where('activity_type', 'new_user_created_company')->whereDate('created_at', Carbon::today())->count();
        $today_companies_imported_admin = $log->where('activity_type', 'admin_created_company')->whereDate('created_at', Carbon::today())->count();
        $today_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->whereDate('created_at', Carbon::today())->count();
        $today_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->whereDate('created_at', Carbon::today())->count();


        $overall_company_updates = $log->where('activity_type', 'company_update')->count();
        $overall_report_creates = $log->where('activity_type', 'report_create')->count();
        $overall_assign_users = $log->where('activity_type', 'assign_user')->count();
        $overall_assign_new_user = $log->where('activity_type', 'assign_new_user')->count();
        $overall_message_sent = $log->where('activity_type', 'message_sent')->count();
        $overall_companies_by_users = $log->where('activity_type', 'new_user_created_company')->count();
        $overall_companies_imported_admin = $log->where('activity_type', 'admin_created_company')->count();
        $overall_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->count();
        $overall_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->count();

        $reported_companies = Company::with('mod_report')->whereHas('mod_report', function ($q) use ($request) {
            $q->where('mod_company_reports.company_id', '!=', 'companies.id');
        })->count();

        $all_companies = Company::with('mod_report')->where('user_id', '0')->count();

        $overall_inqueue = $all_companies - $reported_companies;

        $range_company_updates = $log->where('activity_type', 'company_update')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_report_creates = $log->where('activity_type', 'report_create')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_assign_users = $log->where('activity_type', 'assign_user')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_assign_new_user = $log->where('activity_type', 'assign_new_user')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_message_sent = $log->where('activity_type', 'message_sent')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_companies_by_users = $log->where('activity_type', 'new_user_created_company')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_companies_imported_admin = $log->where('activity_type', 'admin_created_company')->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();
        $range_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->whereBetween('created_at', [$request['date_from'] ." 00:00:00", $request['date_to'] ." 23:59:59"])->count();

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
            'overall_company_updates' => $overall_company_updates,
            'overall_report_creates' => $overall_report_creates,
            'overall_assign_users' => $overall_assign_users,
            'overall_assign_new_user' => $overall_assign_new_user,
            'overall_message_sent' => $overall_message_sent,
            'overall_companies_by_users' => $overall_companies_by_users,
            'overall_companies_imported_admin' => $overall_companies_imported_admin,
            'overall_successful_calls' => $overall_successful_calls,
            'overall_unsuccessful_calls' => $overall_unsuccessful_calls,
            'overall_inqueue' => $overall_inqueue,
            'range_company_updates' => $range_company_updates,
            'range_report_creates' => $range_report_creates,
            'range_assign_users' => $range_assign_users,
            'range_assign_new_user' => $range_assign_new_user,
            'range_message_sent' => $range_message_sent,
            'range_companies_by_users' => $range_companies_by_users,
            'range_companies_imported_admin' => $range_companies_imported_admin,
            'range_successful_calls' => $range_successful_calls,
            'range_unsuccessful_calls' => $range_unsuccessful_calls,
        ));
        $logs = $logs[0];

        return view('admin.reports.callcenter', compact('logs'));
    }
    public function admin_callcenter_reports_details(Request $request, ModLog $log, ModCompanyReport $report) {

        $overall_company_updates = $log->where('activity_type', 'company_update')->count();
        $overall_report_creates = $log->where('activity_type', 'report_create')->count();
        $overall_assign_users = $log->where('activity_type', 'assign_user')->count();
        $overall_assign_new_user = $log->where('activity_type', 'assign_new_user')->count();
        $overall_message_sent = $log->where('activity_type', 'message_sent')->count();
        $overall_successful_calls = $report->whereIn('status', ['Successful Call - Interested',
        'Successful Call - Not Interested', 
        'Successful Call - Agreed to Call Back', 
        'Successful Call - Asked for more details via email'])->count();
        $overall_unsuccessful_calls = $report->whereIn('status', ['Unsuccessful Call - Unreachable',
        'Unsuccessful Call - Wrong number', 
        'Unsuccessful Call - No answer'])->count();

        $reported_companies = Company::with('mod_report')->whereHas('mod_report', function ($q) use ($request) {
            $q->where('mod_company_reports.company_id', '!=', 'companies.id');
        })->count();

        $all_companies = Company::with('mod_report')->where('user_id', '0')->count();

        $overall_inqueue = $all_companies - $reported_companies;

        $logs = array();

        array_push($logs, array(
            'overall_company_updates' => $overall_company_updates,
            'overall_report_creates' => $overall_report_creates,
            'overall_assign_users' => $overall_assign_users,
            'overall_assign_new_user' => $overall_assign_new_user,
            'overall_message_sent' => $overall_message_sent,
            'overall_successful_calls' => $overall_successful_calls,
            'overall_unsuccessful_calls' => $overall_unsuccessful_calls,
            'overall_inqueue' => $overall_inqueue,
        ));
        $logs = $logs[0];

        $all_logs = $log->paginate(10);

        return view('admin.reports.callcenter-details', compact('logs', 'all_logs'));

    }
    

    public function industries()
    {   
        $industries = Industry::with('projects')->orderBy('industry_name', 'asc')->paginate(10);

        return view('admin.industry.index', compact('industries'));
    }

    public function specialities()
    {   
        $specialities = Speciality::with('projects')->orderBy('speciality_name', 'asc')->paginate(30);

        return view('admin.speciality.index', compact('specialities'));
    }

    public function projects()
    {   
        $projects = Project::paginate(10);

        return view('admin.project.index', compact('projects'));
    }

    public function companies()
    {   
        $companies = Company::paginate(10);

        $claims = Claim::paginate(10);

        return view('admin.company.index', compact('companies', 'claims'));
    }

}
