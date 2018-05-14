<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Review;
use App\Interest;
use App\Claim;
use App\Bookmark;
use App\Project;
use App\Company;
use App\Industry;
use App\Speciality;
use App\Message;
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
        ]);

        $user = new User;

        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->user_city = $request['user_city'];
        $user->honeycombs = 0;

        $user->save();

        $user->roles()->sync(request('role'), false);

        $sluggable = $user->replicate();

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

        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
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

        $hasCompany = Company::where('user_id', $user->id)->first();
        if($hasCompany) {
            //delete company
            $user->company->delete();
            //delete specialities
            $user->company->specialities()->detach();
            //delete reviews
            $company_reviews = Review::where('company_id', $user->company->id)->get();
            foreach($company_reviews as $review) {
                $review->delete();
                foreach($review->replies as $reply) {
                    $reply->delete();
                }
            }
            
            //delete claims
            $company_claims = Claim::where('company_id', $user->company->id)->get();
            foreach($company_claims as $claim){
                $claim->delete();
            }
            //delete bookmarks
            $company_bookmarks = Bookmark::where('bookmarked_id', $user->company->id)
            ->where('bookmark_type', 'App\Company')->get();
            foreach($company_bookmarks as $bookmark) {
                $bookmark->delete();
            }
            //delete company projects
            //get projects ids
            $company_projects_ids = Project::where('company_id', $user->company->id)->pluck('id');
            $company_projects_bookmarks = Bookmark::whereIn('bookmarked_id', $company_projects_ids)
            ->where('bookmark_type', 'App\Project')->get();
            foreach($company_projects_bookmarks as $project_bookmark) {
                $project_bookmark->delete();
            }
            //delete interests
            $company_projects_interests = Interest::where('user_id', $company->user->id)->get();

            foreach($company_projects_interests as $interest) {
                $interest->delete();
            }
            $company_projects = Project::where('company_id', $user->company->id)->get();
            foreach($company_projects as $project) {
                $project->delete();
                $project->specialities()->detach();
            }

            //remove the attached image from the folder
            File::delete(public_path($user->company->logo_url));
            File::delete(public_path($user->company->cover_url));
            File::delete(public_path($user->company->reg_doc));
        }

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

            $user = auth()->user();

            $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->take(3)->get();
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
            if ($hascompany) {
                $industries = $industries->whereIn('display', ['projects', 'both'])->orderBy('industry_name')->get();
            }else{
                $industries = $industries->whereIn('display', ['companies', 'both'])->orderBy('industry_name')->get();
            }
            $speciality = new Speciality;
            $specialities = $speciality->all();
            
            return view('front.users.dashboard', compact('user_messages','user', 'hascompany','interested_projects', 'industries', 'specialities'));

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

            return view('front.users.profile', compact('user', 'customer_reviews', 'suppliers_reviews'));

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

            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
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

    public function reviews(User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $user_reviews = $user->reviews()->paginate(3);
            return view('front.users.settings.reviews', compact('user', 'user_reviews'));

        }
    }

    public function supplier_reviews(User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $user_reviews = $user->reviews()->where('reviewer_relation', 'supplier')->paginate(3);
            return view('front.users.settings.reviews', compact('user', 'user_reviews'));

        }
    }

    public function customer_reviews(User $user)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $user_reviews = $user->reviews()->where('reviewer_relation', 'customer')->paginate(3);
            return view('front.users.settings.reviews', compact('user', 'user_reviews'));

        }
    }

    public function review_update(Request $request, User $user, Review $review)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $review->feedback = $request['feedback'];
            $review->update();

            if($review->update()) {
                session()->flash('success', 'Feedback has been updated');
            }else {
                session()->flash('error', 'Sorry, an error occured while editing the review.');
            }

            return back();

        }
    }


    public function review_delete(Request $request, User $user, Review $review)
    {   
        //if trying to access the edit profile
        //and you are not the owner redirect to home

        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));

        }else {
            $review->delete();

            foreach($review->replies as $reply) {
                $reply->delete();
            }

            return back();

        }
    }

    public function update_logo(Request $request, User $user)
    {
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

        $user->update();

        return back();
    }
    public function myprojects(User $user)
    {
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {

            $user = auth()->user();

            $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->take(3)->get();

            $project = new Project;
            $industry = new Industry;

            $suggested_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $user_company = auth()->user()->company;
                $q->where('industries.id', $user_company->industry->id);
            })
            ->whereDoesntHave('interests', function ($query) {
                $user = auth()->user();
                $query->where('user_id', $user->id);
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

            return view('front.users.myprojects', compact('user_messages','user', 'suggested_projects', 'industries', 'specialities'));
        }
    }

    public function opportunities(User $user)
    {
        //if trying to access the dashboard 
        //and you are not the owner redirect to home
        if (!$user->dashboard_owner(auth()->id()) ) {

            return redirect(route('home'));
            
        }else {

            $user = auth()->user();

            $user_messages = Message::with('user')->where('user_id', $user->id)->latest()->take(3)->get();

            $project = new Project;
            $industry = new Industry;

            $suggested_projects = $project->whereHas('industries', function ($q) use ($industry) {
                $user_company = auth()->user()->company;
                $q->where('industries.id', $user_company->industry->id);
            })
            ->whereDoesntHave('interests', function ($query) {
                $user = auth()->user();
                $query->where('user_id', $user->id);
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

            return view('front.users.opportunities', compact('user_messages','user', 'suggested_projects', 'interested_projects', 'industries', 'specialities'));
        }
    }
}
