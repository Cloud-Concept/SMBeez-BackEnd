<?php

namespace App\Http\Controllers;

use App\Industry;
use App\Company;
use App\Project;
use App\Speciality;
use Auth;
use Illuminate\Http\Request;
use Image;
use File;
use DB;

class IndustriesController extends Controller
{

    public function index(Industry $industry)
    {   
        $company = new Company;
        //check if the user has a company
        $hasCompany = $company->where('user_id', Auth::id())->first();

        //get the current user company if the user already has company
        if(!Auth::guest() && $hasCompany) {

            $user_company = Auth::user()->company;

            if($user_company->industry->id != $industry->id) {
                return redirect(route('front.industry.show', $user_company->industry->slug));
            }

        }

        $industries = $industry->all();
        
        $companies = $company->all();
        
        $project = new Project;

        $speciality = new Speciality;

        $specialities = $speciality->all();

        if(Auth::user()) {

            $industry_projects = $project->with('industries')->where('status', 'publish')
            ->where('city', auth()->user()->user_city)->orderBy('relevance_score', 'desc')->orderBy('created_at', 'desc')->paginate(10);

            //show featured projects from the same industry
            $featured_projects = $project->where('is_promoted', 1)
            ->where('status', 'publish')
            ->where('city', Auth::user()->user_city)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

        }else {

            $industry_projects = $project->with('industries')->where('status', 'publish')
            ->orderBy('relevance_score', 'desc')->orderBy('created_at', 'desc')->paginate(10);

            $featured_projects = $project->where('is_promoted', 1)
            ->where('status', 'publish')
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

        }


        return view('front.industry.show', compact('industries', 'industry', 'hasCompany', 'industry_projects', 'companies', 'featured_projects', 'specialities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.industry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'industry_name' => 'required|string|max:255',
            'slug' => 'unique:industries'
        ]);

        $industry = new Industry;

        $industry->industry_name = $request['industry_name'];
        $industry->display = $request['display'];

        if($request->hasFile('industry_img_url')) {

            $industry_img_url     = $request->file('industry_img_url');
            $img_name  = time() . '.' . $industry_img_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/industry/';
            
            //path of the new image
            $path       = public_path('images/industry/' . $img_name);
            //save image to the path
            Image::make($industry_img_url)->save($path);
            //make the field industry_img_url in the table = to the link of img
            $industry->industry_img_url = $path_db . $img_name;
        }

        //save it to the database 
        $industry->save();
        //make the industry sluggable
        $sluggable = $industry->replicate();
        // redirect to the home page
        session()->flash('success', 'Your industry has been created.');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function show(Industry $industry)
    {   
        $company = new Company;
        //check if the user has a company
        $hasCompany = $company->where('user_id', Auth::id())->first();

        //get the current user company if the user already has company
        if(!Auth::guest() && $hasCompany) {

            $user_company = Auth::user()->company;

            if($user_company->industry->id != $industry->id) {
                return redirect(route('front.industry.show', $user_company->industry->slug));
            }

        }

        $industries = $industry->whereIn('display', ['projects', 'both'])->orderBy('industry_name')->get();
        
        $companies = $company->all();
        
        $project = new Project;

        $speciality = new Speciality;

        $specialities = $speciality->all();

        if(Auth::user()) {

            $industry_projects = $project->with('industries')->whereHas('industries', function ($q) use ($industry) {
                $q->where('industries.id', $industry->id);
            })
            ->where('status', 'publish')
            ->where('city', auth()->user()->user_city)->latest()->paginate(10);

            //show featured projects from the same industry
            $featured_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $q->where('industries.id', $industry->id);
            })
            ->where('is_promoted', 1)
            ->where('status', 'publish')
            ->where('city', Auth::user()->user_city)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

        }else {

            $industry_projects = $project->with('industries')->whereHas('industries', function ($q) use ($industry) {
                $q->where('industries.id', $industry->id);
            })
            ->where('status', 'publish')
            ->latest()->paginate(10);

            $featured_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $q->where('industries.id', $industry->id);
            })
            ->where('is_promoted', 1)
            ->where('status', 'publish')
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

        }


        return view('front.industry.show', compact('industries', 'industry', 'hasCompany', 'industry_projects', 'companies', 'featured_projects', 'specialities'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function edit(Industry $industry)
    {   
        $display = array('both' => 'Companies & Projects', 'companies' => 'Companies Only', 'projects' => 'Projects Only');
        return view('admin.industry.edit', compact('industry', 'display'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Industry $industry)
    {
        $industry->industry_name = $request['industry_name'];
        $industry->display = $request['display'];

        if($request->hasFile('industry_img_url')) {

            $industry_img_url     = $request->file('industry_img_url');
            $img_name  = time() . '.' . $industry_img_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/industry/';
            
            //path of the new image
            $path       = public_path('images/industry/' . $img_name);
            //save image to the path
            Image::make($industry_img_url)->save($path);
            //get the old image
            $oldImage = $industry->industry_img_url;
            //make the field industry_img_url in the table = to the link of img
            $industry->industry_img_url = $path_db . $img_name;
            //delete the old image
            File::delete(public_path($oldImage));
        }

        $industry->update();

        session()->flash('success', 'Your industry has been updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Industry $industry)
    {
        //
    }
}
