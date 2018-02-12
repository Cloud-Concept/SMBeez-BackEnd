<?php

namespace App\Http\Controllers;

use App\Company;
use App\Role;
use App\Industry;
use App\Speciality;
use App\Project;
use App\Review;
use App\User;
use App\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use File;
use Auth;
use DB;
use GeoIP;

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
        $user = Auth::user();

        $hasCompany = $company->where('user_id', Auth::id())->first();
        $industries = Industry::all();
        $speciality = new Speciality;
        $specialities = $speciality->all();
        //if user logged in so get companies from his profile city
        if($user) {
            
            $featured_companies = $company->where('is_promoted', 1)
            ->where('status', '!=', '0')
            ->where('city', Auth::user()->user_city)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

            $companies = $company->where('city', Auth::user()->user_city)->latest()->paginate(10);
        }else {
            //this will be changed to the selected country from the menu

            $featured_companies = $company->where('is_promoted', 1)
            ->where('status', '!=', '0')
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

            $companies = $company->latest()->paginate(10);
        }   
        
        return view('front.company.index', compact('companies', 'hasCompany', 'specialities', 'industries', 'featured_companies'));
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
            $industries = $industries->orderBy('industry_name')->get();
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
                'industry_id' => 'required',
                'slug' => 'unique:companies'
            ]);

            $company->company_name = $request['company_name'];
            $company->user_id = auth()->id();
            $company->industry_id = $request['industry_id'];
            $company->company_description = $request['company_description'];
            $company->company_website = $request['company_website'];
            $company->company_phone = $request['company_phone'];
            $company->linkedin_url = $request['linkedin_url'];
            $company->city = $request['city'];
            $company->company_size = $request['company_size'];
            $company->company_type = $request['company_type'];
            $company->status = 1;

            //save it to the database 
            $company->save();
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
            //if save go to company page, if continue go to edit page
            if(Input::get('save')) {
                return redirect(route('front.company.show', $company->slug));
            }elseif(Input::get('edit')) {
                return redirect(route('front.company.edit', $company->slug));
            }
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
        ->where('status', 'closed')
        ->take(8)->latest()->get();
        //get customer reviews
        $customer_reviews = $company->reviews->where('company_id', $company->id)
        ->where('reviewer_relation', 'customer');
        //get suppliers reviews
        $suppliers_reviews = $company->reviews->where('company_id', $company->id)
        ->where('reviewer_relation', 'supplier');

        
        return view('front.company.show', compact('company', 'closed_projects', 'user', 'customer_reviews', 'suppliers_reviews'));
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

        $customer_reviews = $company->reviews->where('company_id', $company->id)
        ->where('reviewer_relation', 'customer');

        $suppliers_reviews = $company->reviews->where('company_id', $company->id)
        ->where('reviewer_relation', 'supplier');

        //allow edit for company owner only
        if($company->is_owner(auth()->id())) {
            return view('front.company.edit', compact('company', 'user', 'customer_reviews', 'suppliers_reviews'));
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
        $company->company_name = $request['company_name'];
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


        if($request->hasFile('reg_doc')) {

            $file = $request->file('reg_doc');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            //store in the storage folder
            $file->storeAs('/', $filename, 'company_files');
            //get the old image
            $oldFile = $company->reg_doc;

            $company->reg_doc = $filename;

            //delete the old image
            File::delete(public_path('companies/files/' . $oldFile));
        }

        $company->update();
        //make the company sluggable
        $sluggable = $company->replicate();
        // redirect to the home page
        session()->flash('success', 'Your company has been created.');

        return back();
    }


    public function update_logo(Request $request, Company $company)
    {
        if($request->hasFile('logo_url')) {

            $logo_url     = $request->file('logo_url');
            $img_name  = time() . '.' . $logo_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/company/';
            //path of the new image
            $path       = public_path('images/company/' . $img_name);
            //save image to the path
            Image::make($logo_url)->resize(130, 43)->save($path);
            //get the old image
            $oldImage = $company->logo_url;
            //make the field logo_url in the table = to the link of img
            $company->logo_url = $path_db . $img_name;
            //delete the old image
            File::delete(public_path($oldImage));
        }

        if($request->hasFile('cover_url')) {

            $cover_url     = $request->file('cover_url');
            $img_name_cover  = time() . '.' . $cover_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db_cover = 'images/company/';
            //path of the new image
            $path_cover       = public_path('images/company/' . $img_name_cover);
            //save image to the path
            Image::make($cover_url)->resize(346, 213)->save($path_cover);
            //get the old image
            $oldCover = $company->cover_url;
            //make the field cover_url in the table = to the link of img
            $company->cover_url = $path_db_cover . $img_name_cover;
            //delete the old image
            File::delete(public_path($oldCover));
        }

        return $company->update();
    }

    public function update_location(Request $request, Company $company)
    {
        $company->location = $request['location'];

        $company->update();

        return back();
    }
    //Stage 1 for claim company
    public function claim_notification(Company $company)
    {   if($company->has_company() == true) {
            return redirect(route('front.company.all'));
        }else {
            return view('front.company.claim-notification', compact('company'));
        }
    }
    //Stage 2 for claim company
    public function claim_application(Company $company)
    {
        return view('front.company.claim-application', compact('company'));
    }
    //Stage 3 for claim company
    public function claim(Request $request, Company $company)
    {
        $claim = new Claim;

        if($company->has_company() == true) {
            return redirect(route('front.company.all'));
        }else {

            $this->validate($request, [
                'role' => 'required|string|max:255',
                'comments' => 'required'
            ]);

            $claim->user_id = auth()->id();
            $claim->company_id = $company->id;
            $claim->role = $request['role'];
            $claim->comments = $request['comments'];

            if($request->hasFile('document')) {

                $file = $request->file('document');

                $filename = time() . '.' . $file->getClientOriginalExtension();
                //store in the storage folder
                $file->storeAs('/', $filename, 'company_files');

                $claim->document = $filename;
            }


            $claim->save();

            return redirect(route('front.company.claim-thanks', $company->slug));
        }
    }
    //Stage 4 for claim company
    public function claim_thanks(Company $company)
    {
        return view('front.company.claim-thanks', compact('company'));
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_industry(Industry $industry)
    {   
        $company = new Company;
        $hasCompany = $company->where('user_id', Auth::id())->first();
        $featured_companies = $company->where('is_promoted', 1)
        ->where('status', '!=', '0')
        ->orderBy(DB::raw('RAND()'))
        ->take(2)
        ->get();

        return view('front.company.showindustry', compact('hasCompany', 'featured_companies', 'industry'));
    }
}
