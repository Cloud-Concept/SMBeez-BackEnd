<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\Welcome;
use App\Mail\NotifyAdmin;
use \App\Repositories\ProjectFunctions;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'user_city' => 'required',
            'phone' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_city' => $data['user_city'],
            'phone' => $data['phone'],
            'honeycombs' => 0,
        ]);

        // set user role as user (4) is user role id
        $user->roles()->attach(4);
        $sluggable = $user->replicate();
        //event(new \App\Events\UserReferred(request()->cookie('ref'), $user));
        
        Mail::to($user)->send(new Welcome);
        Mail::to('info@masharee3.com')->send(new NotifyAdmin('New User', $user->username, $user->email));

        $do = new ProjectFunctions;
        $do->email_log($user->id, $user->email);
        
        return $user;
    }


    public function registered(Request $request, $user)
    {
        if($request['action'] === 'add-company') { 
            //if unlogged user clicked on add company
            return redirect(route('front.user.dashboard', $user->username) . '?action=add-company');
        }elseif($request['action'] === 'add-project' && $user->company ) { 
            //if unlogged user clicked on add project and he have a company
            return redirect(route('front.user.dashboard', $user->username) . '?action=add-project');
        }elseif($request['action'] === 'add-project' && !$user->company ) { 
            //if unlogged user clicked on add project and he dont have a company
            return redirect(route('front.user.dashboard', $user->username) . '?action=add-company');
        }elseif($request['action'] === 'claim-company' ) { 
            //if unlogged user clicked on claim company
            return redirect(route('front.company.claim_application', $request['claim']));
        }elseif($request['action'] === 'write-review' ) {
            //if unlogged user clicked on write review
            return redirect(route('front.company.show', $request['claim'])  . '?action=write-review');
        }else {
            return redirect(route('front.user.dashboard', $user->username));
        }
    }
}
