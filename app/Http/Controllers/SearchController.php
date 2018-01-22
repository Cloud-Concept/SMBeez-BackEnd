<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Industry;
use App\Speciality;

class SearchController extends Controller
{
    public function filter_opportunities(Request $request, Project $project,Industry $industry, Speciality $speciality)
    {	
    	$project = $project->newQuery();

    	if ($request->has('industry')) {
    		$project->with('industries')->whereHas('industries', function ($q) use ($industry, $request) {
	            $q->where('industries.id', $request['industry']);
	        });
    	}


    	if ($request->has('specialities')) {
    		$project->with('specialities')->whereHas('specialities', function ($q) use ($speciality, $request) {
	            $q->where('specialities.id', $request['specialities']);
	        });
    	}

    	return $project->get();
    }
}
