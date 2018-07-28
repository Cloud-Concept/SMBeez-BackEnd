<?php

namespace App\Http\Controllers;

use App\Project;
use App\Industry;
use App\Company;
use App\Speciality;
use App\Interest;
use App\User;
use App\MyFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Mail;
use Auth;
use App\Mail\ProjectCreated;
use App\Mail\ProjectPublished;

use File;
use Session;

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
    /*public function create()
    {
        $industries = new Industry;
        $industries = $industries->orderBy('industry_name')->get();
        $speciality = new Speciality;
        $specialities = $speciality->all();

        return view('front.project.create', compact('industries', 'specialities'));
    }*/

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
            'slug' => 'unique:projects'
        ]);

        
        $project->project_title = $request['project_title'];
        $project->project_description = $request['project_description'];
        $project->budget = $request['budget'];
        if(Input::get('publish')) {
            $project->status = $request['publish'];
        }elseif(Input::get('draft')) {
            $project->status = $request['draft'];
        }
        $project->user_id = auth()->id();
        $project->city = auth()->user()->user_city;
        $project->close_date = Carbon::now('Africa/Cairo')->addDays(60);
        $project->company_id = Company::where('user_id', auth()->id())->pluck('id')->first();
        
        //save it to the database 
        $project->save();

        if($request->hasFile('supportive_docs')) {

            $file = $request->file('supportive_docs');

            foreach($file as $f) {
                $filefullname = $f->getClientOriginalName();
                $filename = time() . '-' . str_slug($f->getClientOriginalName()) . '.' . $f->getClientOriginalExtension();
                //store in the storage folder
                $f->storeAs('/', $filename, 'project_files');

                $project_files = new MyFile;

                $project_files->user_id = $project->user_id;
                $project_files->project_id = $project->id;
                $project_files->file_name = $filefullname;
                $project_files->file_path = $filename;

                $project_files->save();

            }

            Project::addRelevanceScore(6, $project->id);

        }
        
        $specs = explode(',', $request['hidden-speciality_id']);
        //check for specs that already exists in database
        $spec_exists = Speciality::with('projects')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
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
        $specs_ids = $speciality->with('projects')->whereIn('speciality_name', $specs)->pluck('id')->toArray();
        
        //sync project industries
        $project->industries()->sync($request['industry_id'], false);
        //sync project specialities
        $project->specialities()->sync($specs_ids, false);
        //make the project sluggable
        $sluggable = $project->replicate();
        //relevance scoring
        $user = auth()->user();

        //if have published projects
        if($user->projects->count() == 1) {
            Company::addRelevanceScore(1, $user->company->id);
        }

        //if user have 2 closed projects
        $projects_count = $user->projects->where('status', 'closed')->count();

        if($projects_count == 2) {
            Project::addRelevanceScore(5, $project->id);
        }

        if($projects_count == 11) {
            Project::addRelevanceScore(15, $project->id);
        }
        //if rating 4+
        $company = Company::with('reviews')->where('id', $project->company_id)->first();

        if($company->company_overall_exact_rating($project->company_id) >= 4.5) {
            Project::addRelevanceScore(5, $project->id);
        }
        //according to company profile completion
        $profile_completion = array($company->company_description, $company->linkedin_url, $company->company_website,
        $company->company_phone, $company->location, $company->company_email, $company->company_size,
        $company->company_tagline, $company->year_founded, $company->reg_number, $company->reg_doc);

        $current = count(array_filter($profile_completion));

        Project::addRelevanceScore($current, $project->id);
        //owner is verified company?
        if($company->is_verified == 1) {
            Project::addRelevanceScore(30, $project->id);
        }

        // redirect to the home page
        session()->flash('success', 'Your project has been created as ' . $project->save_as);

        if(Input::get('publish')) {
            Mail::to($project->user->email)->send(new ProjectPublished($project));
        }elseif(Input::get('draft')) {
            Mail::to($project->user->email)->send(new ProjectCreated($project));
        }

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
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        $company = new Company;
        $hasCompany = $company->where('user_id', Auth::id())->first();
        //if access deleted project redirect home
        if($project->status == 'deleted') return redirect(route('home'));
        //get projects within the same industry
        $industries = $project->industries->modelKeys();
        //find the related projects to the industry and exclude the draft and closed projects
        $relatedprojects = $project->whereHas('industries', function ($q) use ($industries) {
            $q->whereIn('industries.id', $industries);
        })->where('id', '<>', $project->id)
        ->where('status', 'publish')
        ->where('user_id', '!=', auth()->id())
        ->take(4)->get();

        return view('front.project.show', compact('project', 'relatedprojects', 'hasCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        if($project->is_owner(auth()->id())) {

            $industries = Industry::with('projects')->orderBy('industry_name', 'asc')->get();

            $current_specialities = array();

            foreach($project->specialities as $speciality) {
                $current_specialities[] = $speciality->speciality_name;
            }
            $project_specialities = implode('","', $current_specialities);

            $project_files = explode(',', $project->supportive_docs);

            
            return view('front.project.edit', compact('project', 'industries', 'project_specialities', 'project_files'));
        }else {
            return redirect(route('front.industry.index'));
        }

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

        $project->project_title = $request['project_title'];
        $project->project_description = $request['project_description'];
        $project->budget = $request['budget'];
        $project->city = auth()->user()->user_city;

        if($request->hasFile('supportive_docs')) {

            $file = $request->file('supportive_docs');

            foreach($file as $f) {
                $filefullname = $f->getClientOriginalName();
                $filename = time() . '-' . str_slug($f->getClientOriginalName()) . '.' . $f->getClientOriginalExtension();
                //store in the storage folder
                $f->storeAs('/', $filename, 'project_files');

                $project_files = new MyFile;

                $project_files->user_id = $project->user_id;
                $project_files->project_id = $project->id;
                $project_files->file_name = $filefullname;
                $project_files->file_path = $filename;

                $project_files->save();

            }

            Project::addRelevanceScore(6, $project->id);

        }
        //update it to the database 
        $project->update();

        $specs = explode(',', $request['hidden-speciality_id']);
        //check for specs that already exists in database
        $spec_exists = Speciality::with('projects')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
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
        $specs_ids = $speciality->with('projects')->whereIn('speciality_name', $specs)->pluck('id')->toArray();
        //sync project industries
        $project->industries()->sync($request['industry_id'], true);
        //sync project specialities
        $project->specialities()->sync($specs_ids, true);

        return back();
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

    /**
     * Close the specified project.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function close(Project $project)
    {   
        $project->where('id', $project->id)->update(['status' => 'closed', 'status_on_close' => 'by_owner']);

        //if user have 2 closed projects
        $projects_count = $project->user->projects->where('status', 'closed')->count();
        
        if($projects_count == 2) {
            Company::addRelevanceScore(5, $project->user->company->id);
        }

        if($projects_count == 11) {
            Company::addRelevanceScore(15, $project->user->company->id);
        }
        return redirect(route('front.user.myprojects', $project->user->username));
    }

    /**
     * Publish the specified project.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function publish(Project $project)
    {   
        $project->where('id', $project->id)->update(['status' => 'publish']);

        Mail::to($project->user->email)->send(new ProjectPublished($project));
        
        return back();
    }

    public function admin_edit(Project $project)
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        
        $current_specialities = array();

        foreach($project->specialities as $speciality) {
            $current_specialities[] = $speciality->speciality_name;
        }
        $project_specialities = implode('","', $current_specialities);

        return view('admin.project.edit', compact('project', 'project_specialities'));
    }

    public function admin_update(Request $request, Project $project)
    {
        $project->project_title = $request['project_title'];
        $project->project_description = $request['project_description'];
        $project->budget = $request['budget'];

        if($request->hasFile('supportive_docs')) {

            $file = $request->file('supportive_docs');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            //store in the storage folder
            $file->storeAs('/', $filename, 'project_files');
            //get the old file
            $oldFile = $project->supportive_docs;
            $project->supportive_docs = $filename;
            //delete the old file
            File::delete(public_path('projects/files/' . $oldFile));
        }
        //update it to the database 
        $project->update();

        $specs = explode(',', $request['hidden-speciality_id']);
        //check for specs that already exists in database
        $spec_exists = Speciality::with('projects')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
        //foreach specs add the specialities that is not recorded in the database
        foreach($specs as $spec) {
            $speciality = new Speciality;
            if(!in_array($spec, $spec_exists)) {
                $speciality->speciality_name = $spec;
                $speciality->save();
            }
        }
        //get ids of specialities to attach to the project
        $specs_ids = $speciality->with('projects')->whereIn('speciality_name', $specs)->pluck('id')->toArray();
        //sync project industries
        $project->industries()->sync($request['industry_id'], true);
        //sync project specialities
        $project->specialities()->sync($specs_ids, true);

        return back();
    }

    //promote company to make featured
    public function promote(Project $project)
    {   
        $project->is_promoted = 1;

        Project::addRelevanceScore(8, $project->id);

        $project->update();

        return back();
    }

    public function unpromote(Project $project)
    {
        $project->is_promoted = 0;
        
        Project::addRelevanceScore(-8, $project->id);

        $project->update();

        return back();
    }
}
