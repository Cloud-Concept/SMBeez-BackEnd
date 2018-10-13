<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Mail;
use App\User;
use Auth;
use Socialite;
use URL;
use App\Mail\Welcome;
use \App\Repositories\SMBeezFunctions;
use App\Mail\Mod\NewUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated(Request $request, $user) {

        $user->increment('logins_no', 1);
        $track = new SMBeezFunctions;
        $track->user_logins($user->id);

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
        }elseif($request['action'] === 'express-interest' ) { 
            //if unlogged user clicked on express interest
            return redirect(route('front.project.show', $request['claim']) . '?action=express-interest');
        }elseif($request['action'] === 'write-review' ) {
            //if unlogged user clicked on write review
            return redirect(route('front.company.show', $request['claim'])  . '?action=write-review');
        }elseif(\Laratrust::hasRole('administrator|superadmin')){
            return redirect(route('admin.dashboard'));
        }elseif(\Laratrust::hasRole('moderator')){
            return redirect(route('moderator.companies.mycompanies', $user->username));
        }else {
            return redirect(route('front.user.dashboard', $user->username));
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

        /**
 
    * Handle Social login request
 
    *
 
    * @return response
 
    */
 
   public function socialLogin($social)
 
   {  
          //if unlogged user clicked on add company
          return Socialite::driver($social)->redirect();
   }
 
   /**
 
    * Obtain the user information from Social Logged in.
 
    * @param $social
 
    * @return Response
 
    */
 
   public function handleProviderCallback(Request $request, $social)
 
   {
       if($social === 'facebook') {
        $userSocial = Socialite::driver('facebook')->fields([
            'name', 
            'first_name', 
            'last_name', 
            'email',
            'verified'
        ])->user();
       }else{
        $userSocial = Socialite::driver('linkedin')->user();
       }
    
       $user = User::where(['email' => $userSocial->getEmail()])->first();
       $action_url = URL::previous();
       $parsed_url = parse_url($action_url);
       $action = new SMBeezFunctions;

       if($user){

            Auth::login($user);
            
            $user->increment('logins_no', 1);
            $track = new SMBeezFunctions;
            $track->user_logins($user->id);

            if(isset($parsed_url['query']) && $parsed_url['query'] === 'action=add-company') { 
                //if unlogged user clicked on add company
                return redirect(route('front.user.dashboard', $user) . '?action=add-company');
            }elseif(isset($parsed_url['query']) && $parsed_url['query'] === 'action=add-project' && $user->company ) { 
                //if unlogged user clicked on add project and he have a company
                return redirect(route('front.user.dashboard', $user) . '?action=add-project');
            }elseif(isset($parsed_url['query']) && $parsed_url['query'] === 'action=add-project' && !$user->company ) { 
                //if unlogged user clicked on add project and he dont have a company
                return redirect(route('front.user.dashboard', $user) . '?action=add-company');
            }elseif(isset($parsed_url['query']) && strpos($parsed_url['query'], 'action=express-interest') !== false ) {
                //if unlogged user clicked on claim company
                $string = str_replace(' ', '', $action->get_last_word(1, $parsed_url['query'], 'action=express-interest&name='));
                return redirect(route('front.project.show', $string . '?action=express-interest'));
            }elseif(isset($parsed_url['query']) && strpos($parsed_url['query'], 'action=claim-company') !== false ) {
                //if unlogged user clicked on claim company
                $string = str_replace(' ', '', $action->get_last_word(1, $parsed_url['query'], 'action=claim-company&name='));
                return redirect(route('front.company.claim_application', $string));
            }elseif(isset($parsed_url['query']) && strpos($parsed_url['query'], 'action=write-review') !== false) {
                //if unlogged user clicked on write review
                $string = str_replace(' ', '', $action->get_last_word(1, $parsed_url['query'], 'action=write-review&name='));
                return redirect(route('front.company.show', $string)  . '?action=write-review');
            }else {
                return redirect(route('front.user.dashboard', $user));
            }
 
       }else{

          if($social === 'facebook') {
            $data = ['first_name' => $userSocial->user['first_name'], 'last_name' => $userSocial->user['last_name'], 'email' => $userSocial->getEmail(), 'password' => bcrypt(uniqid()), 'user_city' => 'Cairo', 'honeycombs' => 0];
          }else {
            $data = ['first_name' => $userSocial->user['firstName'], 'last_name' => $userSocial->user['lastName'], 'email' => $userSocial->user['emailAddress'], 'password' => bcrypt(uniqid()), 'user_city' => 'Cairo', 'honeycombs' => 0];
          }
          $user = User::create($data);

          $user->roles()->attach(4);
          $sluggable = $user->replicate();
          event(new \App\Events\UserReferred(request()->cookie('ref'), $user));
          
          Auth::login($user);

          $user->increment('logins_no', 1);
          $track = new SMBeezFunctions;
          $track->user_logins($user->id);

            if(isset($parsed_url['query']) && $parsed_url['query'] === 'action=add-company') { 
                //if unlogged user clicked on add company
                return redirect(route('front.user.dashboard', $user) . '?action=add-company');
            }elseif(isset($parsed_url['query']) && $parsed_url['query'] === 'action=add-project' && $user->company ) { 
                //if unlogged user clicked on add project and he have a company
                return redirect(route('front.user.dashboard', $user) . '?action=add-project');
            }elseif(isset($parsed_url['query']) && $parsed_url['query'] === 'action=add-project' && !$user->company ) { 
                //if unlogged user clicked on add project and he dont have a company
                return redirect(route('front.user.dashboard', $user) . '?action=add-company');
            }elseif(isset($parsed_url['query']) && strpos($parsed_url['query'], 'action=express-interest') !== false ) {
                //if unlogged user clicked on claim company
                $string = str_replace(' ', '', $action->get_last_word(1, $parsed_url['query'], 'action=express-interest&name='));
                return redirect(route('front.project.show', $string . '?action=express-interest'));
            }elseif(isset($parsed_url['query']) && strpos($parsed_url['query'], 'action=claim-company') !== false ) {
                //if unlogged user clicked on claim company
                $string = str_replace(' ', '', $action->get_last_word(1, $parsed_url['query'], 'action=claim-company&name='));
                return redirect(route('front.company.claim_application', $string));
            }elseif(isset($parsed_url['query']) && strpos($parsed_url['query'], 'action=write-review') !== false) {
                //if unlogged user clicked on write review
                $string = str_replace(' ', '', $action->get_last_word(1, $parsed_url['query'], 'action=write-review&name='));
                return redirect(route('front.company.show', $string)  . '?action=write-review');
            }else {
                return redirect(route('front.user.dashboard', $user));
            }

       }
 
   }
}
