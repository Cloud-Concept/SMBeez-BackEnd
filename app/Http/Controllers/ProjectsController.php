<?php

namespace App\Http\Controllers;

use App\Project;
use App\Industry;
use App\Company;
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
        return view('front.project.create', compact('industries'));
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
        $project->save_as = $request['save_as'];
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
        return view('front.project.show');
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
