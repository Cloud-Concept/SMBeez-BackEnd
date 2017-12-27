<?php

namespace App\Http\Controllers;

use App\Company;
use App\Role;
use App\Industry;
use App\Speciality;
use App\Project;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Image;
use File;
use Auth;
use DB;

class CompaniesController extends Controller
{   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $company = new Company;
        $hasCompany = $company->where('user_id', Auth::id())->first();
        $industries = Industry::all();
        $companies = $company->all();
        $featured_companies = $company->where('is_promoted', 1)
        ->where('status', '!=', '0')
        ->orderBy(DB::raw('RAND()'))
        ->take(2)
        ->get();

        return view('front.company.index', compact('companies', 'hasCompany', 'industries', 'featured_companies', 'company_overall_rating'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {   
        //check if user have company so restrict access to create page
        if($company->has_company() == true) {
            return redirect(route('front.company.all'));
        }else {
            $industries = new Industry;
            $industries = $industries->all();
            $speciality = new Speciality;
            $specialities = $speciality->all();
            return view('front.company.create', compact('industries', 'specialities'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $company = new Company;

        if($company->has_company() == true) {
            return redirect(route('front.company.all'));
        }else {
            $this->validate($request, [
                'company_name' => 'required|string|max:255',
                'company_description' => 'required',
                'company_phone' => 'required',
                'city' => 'required',
                'company_size' => 'required',
                'year_founded' => 'required',
                'company_type' => 'required',
                'reg_number' => 'required',
                'reg_date' => 'required',
                'location' => 'required',
                'logo_url' => 'required',
                'industry_id' => 'required',
                'company_email' => 'required|string|email|max:255',
                'slug' => 'unique:companies'
            ]);

            $company->company_name = $request['company_name'];
            $company->user_id = auth()->id();
            $company->company_description = $request['company_description'];
            $company->company_tagline = $request['company_tagline'];
            $company->company_website = $request['company_website'];
            $company->company_email = $request['company_email'];
            $company->company_phone = $request['company_phone'];
            $company->linkedin_url = $request['linkedin_url'];
            $company->city = $request['city'];
            $company->company_size = $request['company_size'];
            $company->year_founded = $request['year_founded'];
            $company->company_type = $request['company_type'];
            $company->reg_number = $request['reg_number'];
            $company->reg_date = $request['reg_date'];
            $company->location = $request['location'];
            $company->logo_url = $request['logo_url'];
            $company->cover_url = $request['cover_url'];
            $company->status = 1;

            if($request->hasFile('logo_url')) {

                $logo_url     = $request->file('logo_url');
                $img_name  = time() . '.' . $logo_url->getClientOriginalExtension();
                //path to year/month folder
                $date_path = public_path('images/company/' . date('Y') . '/' . date('m'));
                $date_path_db = 'images/company/' . date('Y') . '/' . date('m') . '/';
                //check if date foler exists if not create it
                if(!File::exists($date_path)) {
                    File::makeDirectory($date_path, 666, true);
                }
                //path of the new image
                $path       = $date_path . '/' . $img_name;
                //save image to the path
                Image::make($logo_url)->resize(130, 43)->save($path);
                //get the old image
                $oldImage = $company->logo_url;
                //make the field logo_url in the table = to the link of img
                $company->logo_url = $date_path_db . $img_name;
                //delete the old image
                File::delete(public_path($oldImage));
            }

            if($request->hasFile('cover_url')) {

                $cover_url     = $request->file('cover_url');
                $img_name  = time() . '.' . $cover_url->getClientOriginalExtension();
                //path to year/month folder
                $date_path = public_path('images/company/' . date('Y') . '/' . date('m'));
                $date_path_db = 'images/company/' . date('Y') . '/' . date('m') . '/';
                //check if date foler exists if not create it
                if(!File::exists($date_path)) {
                    File::makeDirectory($date_path, 666, true);
                }
                //path of the new image
                $path       = $date_path . '/' . $img_name;
                //save image to the path
                Image::make($cover_url)->resize(346, 213)->save($path);
                //get the old image
                $oldImage = $company->cover_url;
                //make the field cover_url in the table = to the link of img
                $company->cover_url = $date_path_db . $img_name;
                //delete the old image
                File::delete(public_path($oldImage));
            }

            //save it to the database 
            $company->save();
            //sync company industries
            $company->industries()->sync($request['industry_id'], false);
            //sync company specialities
            $company->specialities()->sync($request['speciality_id'], false);
            //change current user to company role
            $roles = new Role;
            $role = $roles->where('name', 'company')->pluck('id');
            $user = Auth::User();
            $user->roles()->sync($role, true);
            //make the company sluggable
            $sluggable = $company->replicate();
            // redirect to the home page
            session()->flash('success', 'Your company has been created.');

            return redirect(route('front.company.show', $company->slug));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, User $user)
    {   
        $project = new Project;
        
        $closed_projects = $project->where('user_id', $company->user_id)
        ->where('status', 'publish')
        ->where('awarded_to', '!=', null)->take(8)->get();
        
        $customer_reviews = $company->reviews->where('company_id', $company->id)
        ->where('reviewer_relation', 'customer');

        $suppliers_reviews = $company->reviews->where('company_id', $company->id)
        ->where('reviewer_relation', 'supplier');
        
        if($company->reviews->count() > 0) {
            //sum of all reviews rates
            $customer_overall = DB::table('reviews')
            ->select(DB::raw("SUM(overall_rate + selection_process_rate + money_value_rate + delivery_quality_rate)"))
            ->where('company_id', $company->id)
            ->where('reviewer_relation', 'customer')->get();

            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 4 which means 4 types of rates
            foreach ($customer_overall[0] as $key => $value) {
                $value = (int)$value;
            }
            $customer_overall = ceil($value / ($customer_reviews->count() * 4));

            //sum of all reviews rates
            $suppliers_overall = DB::table('reviews')
            ->select(DB::raw("SUM(overall_rate + selection_process_rate + money_value_rate + delivery_quality_rate)"))
            ->where('company_id', $company->id)
            ->where('reviewer_relation', 'supplier')->get();

            //the sum of reviews rates divided by the reviews number which is the 
            //reviews count * 4 which means 4 types of rates
            foreach ($suppliers_overall[0] as $key => $value) {
                $value = (int)$value;
            }
            $suppliers_overall = ceil($value / ($suppliers_reviews->count() * 4));
        }
        
        return view('front.company.show', compact('company', 'closed_projects', 'user', 'customer_reviews', 'suppliers_reviews', 'customer_overall', 'suppliers_overall'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {   
        $user = auth()->user();
        //allow edit for company owner only
        if($company->is_owner(auth()->id())) {
            return view('front.company.edit', compact('company', 'user'));
        }else {
            return redirect(route('front.company.all'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
