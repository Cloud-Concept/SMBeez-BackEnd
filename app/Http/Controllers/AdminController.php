<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	//redirect to admin dashboard
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }
    //view admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
