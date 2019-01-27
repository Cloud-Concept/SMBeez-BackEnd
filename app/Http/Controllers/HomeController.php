<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Newsletter;
use Auth;
use App\ModCompanyReport;
use App\Company;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('home');
    }


    public function about()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        return view('layouts.about');
    }

    public function privacy_policy()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        return view('layouts.privacy');
    }

    public function our_team()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        return view('layouts.team');
    }

    public function subscribe(Request $request)
    {   
        
        if ( ! Newsletter::isSubscribed($request->email) ) 
        {   
            if(!Auth::guest() && !Auth::user()->company) {
                Newsletter::subscribe($request->email, ['FNAME'=>Auth::user()->first_name, 'LNAME'=>Auth::user()->last_name]);
            }elseif(!Auth::guest() && Auth::user()->company) {
                Newsletter::subscribe($request->email, ['FNAME'=>Auth::user()->first_name, 'LNAME'=>Auth::user()->last_name, 'COMPANY'=>Auth::user()->company->company_name]);
            }else {
                Newsletter::subscribe($request->email);
            }
            session()->flash('msg', 'شكراً لاشتراكك.');
        }else {
            session()->flash('msg', 'نأسف! انت بالفعل مشترك.');
        }
        
        
        return back();
    }

    public function unsubscribe(Request $request)
    {   
        
        if ( Newsletter::isSubscribed($request->email) ) 
        {   
            Newsletter::unsubscribe($request->email);
            session()->flash('msg', 'لقد تم ازالتك من نشرة الرسائل.');
        }else {
            session()->flash('msg', 'انت غير مشترك في النشرة.');
        }
        
        
        return back();
    }

    public function status()
    {   
        /*$chunks = ModCompanyReport::get()->chunk(1000)->toArray();

        foreach($chunks as $chunk) {
            foreach(array_reverse($chunk) as $status) {
                $company = Company::where('id', $status['company_id'])->first();
                if($company) {
                    $company->mod_status = $status['status'];
                    $company->update();
                }else{
                    continue;
                }
            }
        }*/
        
        return 'Thanks All Done';
    }
}
