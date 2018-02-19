<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Project;
use App\Company;
use App\Industry;
use App\Speciality;
use Image;
use File;
use DB;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::orderBy('id', 'asc')->with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'unique:users'
        ]);

        $user = new User;

        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->user_city = $request['user_city'];
        $user->honeycombs = 0;

        $user->save();

        $user->roles()->sync(request('role'), false);

        if($user->save()) {
            session()->flash('success', 'User has been added');
            return redirect()->route('admin.user.edit', $user->username);
        }else {
            session()->flash('error', 'Sorry, an error occured while creating the user.');
            return redirect()->route('admin.user.create');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];

        if($request->hasFile('profile_pic_url')) {

            $profile_pic_url     = $request->file('profile_pic_url');
            $img_name  = time() . '.' . $profile_pic_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/users/';
            //path of the new image
            $path       = public_path('images/users/' . $img_name);
            //save image to the path
            Image::make($profile_pic_url)->resize(48, 48)->save($path);
            //get the old image
            $oldImage = $user->profile_pic_url;
            //make the field profile_pic_url in the table = to the link of img
            $user->profile_pic_url = $path_db . $img_name;
            //delete the old image
            File::delete(public_path($oldImage));
        }

        //update it to the database
        if(!empty($request['password'])){
            $user->password = bcrypt($request['password']);
        }

        $user->update();

        $user->roles()->sync(request('role'), true);

        if($user->update()) {
            session()->flash('success', 'User has been updated');
        }else {
            session()->flash('error', 'Sorry, an error occured while editing the user.');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        //delete from pviot table
        $user->roles()->detach();
        //remove the attached image from the folder
        File::delete(public_path($user->profile_pic_url));

        session()->flash('success', 'User has been deleted');

        return redirect(route('admin.user.index'));
    }


    // Front End Stuff

    public function dashboard(User $user)
    {   
        //if trying to access the dashboard 
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            //get the user interests
            $interests = $user->interests->modelKeys();
            $company = new Company;
            $hascompany = $company->where('user_id', Auth::id())->first();

            $project = new Project;
            //find the interested projects where the user id is the user_id in the interests table
            $interested_projects = $project->whereHas('interests', function ($q) use ($interests) {
                $q->whereIn('interests.id', $interests);
            })->where('id', '<>', $user->id)->get();

            $industries = new Industry;
            $industries = $industries->orderBy('industry_name')->get();
            $speciality = new Speciality;
            $specialities = $speciality->all();

            return view('front.users.dashboard', compact('user', 'hascompany','interested_projects', 'industries', 'specialities'));

        }
    }


    public function profile(User $user)
    {   
        //if trying to access the dashboard 
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            if($user->company) {
                
                $customer_reviews = $user->company->reviews->where('company_id', $user->company->id)
                ->where('reviewer_relation', 'customer');

                $suppliers_reviews = $user->company->reviews->where('company_id', $user->company->id)
                ->where('reviewer_relation', 'supplier');

            }

            $industries = Industry::all();

            return view('front.users.profile', compact('user', 'customer_reviews', 'suppliers_reviews', 'industries'));

        }
    }

    public function edit_profile_settings(User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            return view('front.users.settings.basic-info', compact('user'));

        }
    }

    public function update_basic_info(Request $request, User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];

            if($request->hasFile('profile_pic_url')) {

                $profile_pic_url     = $request->file('profile_pic_url');
                $img_name  = time() . '.' . $profile_pic_url->getClientOriginalExtension();
                //path to year/month folder
                $path_db = 'images/users/';
                //path of the new image
                $path       = public_path('images/users/' . $img_name);
                //save image to the path
                Image::make($profile_pic_url)->resize(48, 48)->save($path);
                //get the old image
                $oldImage = $user->profile_pic_url;
                //make the field profile_pic_url in the table = to the link of img
                $user->profile_pic_url = $path_db . $img_name;
                //delete the old image
                File::delete(public_path($oldImage));
            }

            //update it to the database
            if(!empty($request['password'])){
                $user->password = bcrypt($request['password']);
            }

            $user->update();

            if($user->update()) {
                session()->flash('success', 'User has been updated');
            }else {
                session()->flash('error', 'Sorry, an error occured while editing the user.');
            }

            return redirect(route('front.user.profile', $user->username));

        }
    }


    public function edit_location(User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            return view('front.users.settings.location', compact('user'));

        }
    }

    public function update_location(Request $request, User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {

            $user->user_city = $request['user_city'];

            $user->update();

            if($user->update()) {
                session()->flash('success', 'User has been updated');
            }else {
                session()->flash('error', 'Sorry, an error occured while editing the user.');
            }

            return redirect(route('front.user.profile', $user->username));

        }
    }

    public function myprojects(User $user)
    {
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {

            $project = new Project;
            $industry = new Industry;

            $suggested_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $user_company = auth()->user()->company;
                $q->where('industries.id', $user_company->industry->id);
            })
            ->where('is_promoted', 1)
            ->where('status', 'publish')
            ->where('user_id', '!=', $user->id)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();

            $industries = new Industry;
            $industries = $industries->orderBy('industry_name')->get();
            $speciality = new Speciality;
            $specialities = $speciality->all();

            return view('front.users.myprojects', compact('user', 'suggested_projects', 'industries', 'specialities'));
        }
    }

    public function opportunities(User $user)
    {
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {

            $project = new Project;
            $industry = new Industry;

            $suggested_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $user_company = auth()->user()->company;
                $q->where('industries.id', $user_company->industry->id);
            })
            ->where('is_promoted', 1)
            ->where('status', 'publish')
            ->where('user_id', '!=', $user->id)
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->get();


            $interests = $user->interests->modelKeys();
            //find the interested projects where the user id is the user_id in the interests table
            $interested_projects = $project->whereHas('interests', function ($q) use ($interests) {
                $q->whereIn('interests.id', $interests);
            })->where('id', '<>', $user->id)->get();

            $industries = new Industry;
            $industries = $industries->orderBy('industry_name')->get();
            $speciality = new Speciality;
            $specialities = $speciality->all();

            return view('front.users.opportunities', compact('user', 'suggested_projects', 'interested_projects', 'industries', 'specialities'));
        }
    }
}
