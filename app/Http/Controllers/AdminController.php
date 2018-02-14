<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Review;
use App\Project;
use App\Industry;
use App\Speciality;
use App\Claim;

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
        $users = User::count();
        $companies = Company::with('users')->count();
        $customer_reviews = Review::with('companies')->where('reviewer_relation', 'customer')->count();
        $supplier_reviews = Review::with('companies')->where('reviewer_relation', 'supplier')->count();
        $projects = Project::with('users')->count();
        $completed_projects = Project::with('users')->where('status', 'closed')->count();
        $industries = Industry::with('projects')->count();
        $specialities = Speciality::with('project')->count();

        return view('admin.dashboard', compact('users', 'companies', 'customer_reviews', 'supplier_reviews', 'projects', 'completed_projects', 'industries', 'specialities'));
    }

    public function industries()
    {   
        $industries = Industry::with('projects')->orderBy('industry_name', 'asc')->paginate(10);

        return view('admin.industry.index', compact('industries'));
    }

    public function specialities()
    {   
        $specialities = Speciality::with('projects')->orderBy('speciality_name', 'asc')->paginate(30);

        return view('admin.speciality.index', compact('specialities'));
    }

    public function projects()
    {   
        $projects = Project::paginate(10);

        return view('admin.project.index', compact('projects'));
    }

    public function companies()
    {   
        $companies = Company::paginate(10);

        $claims = Claim::paginate(10);

        return view('admin.company.index', compact('companies', 'claims'));
    }
}
