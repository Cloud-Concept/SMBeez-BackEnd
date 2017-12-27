<?php

namespace App\Http\Controllers;

use App\Project;
use App\Industry;
use App\Company;
use App\Speciality;
use App\Interest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use File;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $speciality = new Speciality;
        $specialities = $speciality->all();

        return view('front.project.create', compact('industries', 'specialities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $project = new Project;

        $this->validate($request, [
            'project_title' => 'required|string|max:255',
            'project_description' => 'required',
            'budget' => 'required',
            'status' => 'required',
            'slug' => 'unique:projects'
        ]);

        $project->project_title = $request['project_title'];
        $project->project_description = $request['project_description'];
        $project->budget = $request['budget'];
        $project->status = $request['status'];
        $project->user_id = auth()->id();
        $project->close_date = Carbon::now('Asia/Dubai')->addDays(60);
        $project->company_id = Company::where('user_id', auth()->id())->pluck('id')->first();
        

        if($request->hasFile('supportive_docs')) {

            $file = $request->file('supportive_docs');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            //store in the storage folder
            $file->storeAs('projects/files', $filename);

            $project->supportive_docs = $filename;
        }
        //save it to the database 
        $project->save();

        //sync project industries
        $project->industries()->sync($request['industry_id'], false);
        //sync project specialities
        $project->specialities()->sync($request['speciality_id'], false);
        //make the project sluggable
        $sluggable = $project->replicate();
        // redirect to the home page
        session()->flash('success', 'Your project has been created as ' . $project->save_as);


        return redirect(route('front.project.show', $project->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   
        //get projects within the same industry
        $industries = $project->industries->modelKeys();
        //find the related projects to the industry and exclude the draft and closed projects
        $relatedprojects = $project->whereHas('industries', function ($q) use ($industries) {
            $q->whereIn('industries.id', $industries);
        })->where('id', '<>', $project->id)
        ->where('status', 'publish')
        ->where('user_id', '!=', auth()->id())
        ->take(4)->get();

        return view('front.project.show', compact('project', 'relatedprojects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
