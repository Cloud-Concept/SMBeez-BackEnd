<?php

namespace App\Http\Controllers;

use App\Company;
use App\Industry;
use Illuminate\Http\Request;
use Image;
use File;
use Auth;

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
        return view('front.company.index', compact('companies', 'hasCompany', 'industries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $industries = new Industry;
        $industries = $industries->all();
        return view('front.company.create', compact('industries'));
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
        //make the company sluggable
        $sluggable = $company->replicate();
        // redirect to the home page
        session()->flash('success', 'Your company has been created.');

        return redirect(route('front.company.show', $company->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('front.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
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
