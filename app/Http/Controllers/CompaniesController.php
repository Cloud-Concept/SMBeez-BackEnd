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
        //check if user have company so restrict access to create page
        if($company->has_company() == true) {
            return redirect(route('front.company.all'));
        }else {
            //check if the company already exists then move to claim company
            if($company->exist('company_name', $request['company_name'])) {
                //get the slug
                $slug = $company->where('company_name', $request['company_name'])->first();
                //go to claim this company page
                return redirect(route('front.company.claim_notification', $slug->slug));

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
                //explode all specifications
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
                $company->specialities()->sync($specs_ids, false);

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

        $current_specialities = array();

        foreach($company->specialities as $speciality) {
            $current_specialities[] = $speciality->speciality_name;
        }
        $company_specialities = implode('","', $current_specialities);

        //allow edit for company owner only
        if($company->is_owner(auth()->id())) {
            return view('front.company.edit', compact('company', 'user', 'customer_reviews', 'suppliers_reviews', 'company_specialities'));
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
        //make the company sluggable
        $sluggable = $company->replicate();
        // redirect to the home page
        session()->flash('success', 'Your company has been updated.');

        return back();
    }


    public function update_logo(Request $request, Company $company)
    {
        if($request->hasFile('logo_url')) {

            $logo_url     = $request->file('logo_url');
            $img_name  = time() . $logo_url->getClientOriginalName() . '.' . $logo_url->getClientOriginalExtension();
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
            $img_name_cover  = time() . $cover_url->getClientOriginalName() . '.' . $cover_url->getClientOriginalExtension();
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

        $company->update();

        return back();
    }

    public function update_location(Request $request, Company $company)
    {
        $company->location = $request['location'];

        $company->update();

        return back();
    }
    //Stage 1 for claim company
    public function claim_notification(Company $company)
    {   
        //if user already sent a claim request
        //if user trying to access a company that is already owned and verified
        //if user trying to access his company
        //if user already have company assigned to him
        if($company->requested_claim(auth()->id(), $company->id) || $company->has_company() == true || $company->is_owner(auth()->id()) || $company->is_verified != null) {
            return redirect(route('front.company.all'));
        }else {
            return view('front.company.claim-notification', compact('company'));
        }
    }
    //Stage 2 for claim company
    public function claim_application(Company $company)
    {   
        //check if user is not logged in
        if(Auth::guest()) {
            return redirect(route('login')); 
        }
        //if user already sent a claim request
        //if user trying to access a company that is already owned and verified
        //if user trying to access his company
        //if user already have company assigned to him
        if($company->requested_claim(auth()->id(), $company->id) || $company->has_company() == true || $company->is_owner(auth()->id()) || $company->is_verified != null) {
            return redirect(route('front.company.all'));
        }else {
            return view('front.company.claim-application', compact('company'));
        }
    }
    //Stage 3 for claim company
    public function claim(Request $request, Company $company)
    {
        $claim = new Claim;
        //if he user requested claim
        //if the user already have a company
        //if the user already the owner of the company
        //if the company already a verified company
        if($company->requested_claim(auth()->id(), $company->id) || $company->has_company() == true || $company->is_owner(auth()->id()) || $company->is_verified != null) {
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
    //create company for superadmins
    public function admin_create()
    {
        return view('admin.company.create');
    }

    public function admin_store(Request $request)
    {
        $company = new Company;

        //check if the company already exists then move to claim company
        if($company->exist('company_name', $request['company_name'])) {
            //get the slug
            $slug = $company->where('company_name', $request['company_name'])->first();
            //go to claim this company page
            return redirect(route('admin.company.edit', $slug->slug));

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
            $company->user_id = 0;
            $company->industry_id = $request['industry_id'];
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
            $company->status = 1;


            if($request->hasFile('logo_url')) {

                $logo_url     = $request->file('logo_url');
                $img_name  = time() . $logo_url->getClientOriginalName() . '.' . $logo_url->getClientOriginalExtension();
                //path to year/month folder
                $path_db = 'images/company/';
                //path of the new image
                $path       = public_path('images/company/' . $img_name);
                //save image to the path
                Image::make($logo_url)->resize(130, 43)->save($path);
                //make the field logo_url in the table = to the link of img
                $company->logo_url = $path_db . $img_name;
            }

            if($request->hasFile('cover_url')) {

                $cover_url     = $request->file('cover_url');
                $img_name_cover  = time() . $cover_url->getClientOriginalName() . '.' . $cover_url->getClientOriginalExtension();
                //path to year/month folder
                $path_db_cover = 'images/company/';
                //path of the new image
                $path_cover       = public_path('images/company/' . $img_name_cover);
                //save image to the path
                Image::make($cover_url)->resize(346, 213)->save($path_cover);
                //make the field cover_url in the table = to the link of img
                $company->cover_url = $path_db_cover . $img_name_cover;
            }

            if($request->hasFile('reg_doc')) {

                $file = $request->file('reg_doc');

                $filename = time() . '.' . $file->getClientOriginalExtension();
                //store in the storage folder
                $file->storeAs('/', $filename, 'company_files');

                $company->reg_doc = $filename;
            }
            //save it to the database 
            $company->save();
            //explode all specifications
            $specs = explode(',', $request['hidden-speciality_id']);
            //check for specs that already exists in database
            $spec_exists = Speciality::with('companies')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
            //foreach specs add the specialities that is not recorded in the database
            foreach($specs as $spec) {
                $speciality = new Speciality;
                if(!in_array($spec, $spec_exists)) {
                    $speciality->speciality_name = $spec;
                    $speciality->save();
                }
            }
            //get ids of specialities to attach to the project
            $specs_ids = $speciality->with('companies')->whereIn('speciality_name', $specs)->pluck('id')->toArray();
            //sync project specialities
            $company->specialities()->sync($specs_ids, false);

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
            return redirect(route('admin.company.edit', $company->slug));
        }
    }
    //Edit company for superadmins
    public function admin_edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }
    public function admin_update(Request $request, Company $company)
    {
        $company->company_name = $request['company_name'];
        $company->company_description = $request['company_description'];
        $company->company_tagline = $request['company_tagline'];
        $company->company_website = $request['company_website'];
        $company->company_email = $request['company_email'];
        $company->company_phone = $request['company_phone'];
        $company->linkedin_url = $request['linkedin_url'];
        $company->location = $request['location'];
        $company->city = $request['city'];
        $company->company_size = $request['company_size'];
        $company->year_founded = $request['year_founded'];
        $company->company_type = $request['company_type'];
        $company->reg_number = $request['reg_number'];
        $company->reg_date = $request['reg_date'];


        if($request->hasFile('logo_url')) {

            $logo_url     = $request->file('logo_url');
            $img_name  = time() . $logo_url->getClientOriginalName() . '.' . $logo_url->getClientOriginalExtension();
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
            $img_name_cover  = time() . $cover_url->getClientOriginalName() . '.' . $cover_url->getClientOriginalExtension();
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

        $specs = explode(',', $request['hidden-speciality_id']);
        //check for specs that already exists in database
        $spec_exists = Speciality::with('companies')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
        //foreach specs add the specialities that is not recorded in the database
        foreach($specs as $spec) {
            $speciality = new Speciality;
            if(!in_array($spec, $spec_exists)) {
                $speciality->speciality_name = $spec;
                $speciality->save();
            }
        }
        //get ids of specialities to attach to the project
        $specs_ids = $speciality->with('companies')->whereIn('speciality_name', $specs)->pluck('id')->toArray();
        //sync project specialities
        $company->specialities()->sync($specs_ids, true);
        //make the company sluggable
        $sluggable = $company->replicate();
        // redirect to the home page
        session()->flash('success', 'Your company has been updated.');

        return back();
    }
    //promote company to make featured
    public function promote(Company $company)
    {   
        $company->is_promoted = 1;

        $company->update();

        return back();
    }

    public function unpromote(Company $company)
    {
        $company->is_promoted = 0;
        
        $company->update();

        return back();
    }
    //verify company
    public function verify(Company $company)
    {   
        $company->is_verified = 1;

        $company->update();

        return back();
    }

    public function unverify(Company $company)
    {
        $company->is_verified = 0;
        
        $company->update();

        return back();
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
