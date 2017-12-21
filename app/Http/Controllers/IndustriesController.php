<?php

namespace App\Http\Controllers;

use App\Industry;
use App\Company;
use App\Project;
use Auth;
use Illuminate\Http\Request;
use Image;
use File;
use DB;

class IndustriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $industries = new Industry;
        $industries_1 = $industries->skip(0)->take(3)->get();
        $industries_2 = $industries->skip(3)->take(2)->get();
        $industries_3 = $industries->skip(5)->take(3)->get();
        $industries_4 = $industries->skip(8)->take(3)->get();
        $industries = $industries->pluck('id');
        return view('front.industry.index', compact('industries','industries_1','industries_2','industries_3','industries_4'));
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
            'industry_img_url' => 'required',
            'slug' => 'unique:industries'
        ]);

        $industry = new Industry;

        $industry->industry_name = $request['industry_name'];
        $industry->industry_img_url = $request['industry_img_url'];

        if($request->hasFile('industry_img_url')) {

            $industry_img_url     = $request->file('industry_img_url');
            $img_name  = time() . '.' . $industry_img_url->getClientOriginalExtension();
            //path to year/month folder
            $date_path = public_path('images/industry/' . date('Y') . '/' . date('m'));
            $date_path_db = 'images/industry/' . date('Y') . '/' . date('m') . '/';
            //check if date foler exists if not create it
            if(!File::exists($date_path)) {
                File::makeDirectory($date_path, 666, true);
            }
            //path of the new image
            $path       = $date_path . '/' . $img_name;
            //save image to the path
            Image::make($industry_img_url)->save($path);
            //get the old image
            $oldImage = $industry->industry_img_url;
            //make the field industry_img_url in the table = to the link of img
            $industry->industry_img_url = $date_path_db . $img_name;
            //delete the old image
            File::delete(public_path($oldImage));
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
    {   $industries = $industry->all();
        $company = new Company;
        $companies = $company->all();
        $hasCompany = $company->where('user_id', Auth::id())->first();
        $project = new Project;
        $featured_projects = $project->where('is_promoted', 1)
        ->where('status', '!=', 'closed')
        ->where('save_as', '!=', 'draft')
        ->orderBy(DB::raw('RAND()'))
        ->take(2)
        ->get();
        return view('front.industry.show', compact('industries', 'hasCompany', 'industry', 'companies', 'featured_projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function edit(Industry $industry)
    {
        //
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
        //
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
