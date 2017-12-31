<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Project;
use App\Industry;
use Image;
use File;
use DB;

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
        $user->honeycombs = 0;

        $user->save();

        $user->roles()->sync(request('role'), false);

        if($user->save()) {
            session()->flash('success', 'User has been added');
            return redirect()->route('admin.user.edit', $user->id);
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

            $profile_img     = $request->file('profile_pic_url');
            $img_name  = time() . '_' . '.' . $profile_img->getClientOriginalExtension();
            //path to year/month folder
            $date_path = public_path('images/users/' . date('Y') . '/' . date('m'));
            $date_path_db = 'images/users/' . date('Y') . '/' . date('m') . '/';
            //check if date foler exists if not create it
            if(!File::exists($date_path)) {
                File::makeDirectory($date_path, 666, true);
            }
            //path of the new image
            $path       = $date_path . '/' . $img_name;
            //save image to the path
            Image::make($profile_img)->save($path);
            //get the old image
            $oldImage = $user->profile_pic_url;
            //make the field profile_pic_url in the products table = to the link of img
            $user->profile_pic_url = $date_path_db . $img_name;
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

            $project = new Project;
            //find the interested projects where the user id is the user_id in the interests table
            $interested_projects = $project->whereHas('interests', function ($q) use ($interests) {
                $q->whereIn('interests.id', $interests);
            })->where('id', '<>', $user->id)->get();

            return view('front.users.dashboard', compact('user', 'interested_projects'));

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

            return view('front.users.myprojects', compact('user', 'suggested_projects'));
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

            return view('front.users.opportunities', compact('user', 'suggested_projects', 'interested_projects'));
        }
    }
}
