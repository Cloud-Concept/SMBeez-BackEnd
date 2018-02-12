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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|min:3|unique:users',
            'user_city' => 'required',
            'phone' => 'required|min:5',
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
            'user_city' => $data['user_city'],
            'phone' => $data['phone'],
            'honeycombs' => 0,
        ]);

        if(Input::hasFile('profile_pic_url')) {

            $profile_pic_url     = Input::file('profile_pic_url');
            $img_name  = time() . '.' . $profile_pic_url->getClientOriginalExtension();
            //path to year/month folder
            $path_db = 'images/users/';
            //path of the new image
            $path       = public_path('images/users/' . $img_name);
            //save image to the path
            Image::make($profile_pic_url)->resize(48, 48)->save($path);
            //make the field profile_pic_url in the table = to the link of img
            $user->profile_pic_url = $path_db . $img_name;

        }
        // set user role as user (4) is user role id
        $user->roles()->attach(4);

        event(new \App\Events\UserReferred(request()->cookie('ref'), $user));
        
        Mail::to($user)->send(new Welcome);

        return $user;

    }
}
