<?php

namespace App\Http\Controllers;

use App\Speciality;
use Illuminate\Http\Request;

class SpecialitiesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.speciality.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $specs = explode(',', $request['hidden-speciality_id']);
        //check for specs that already exists in database
        $spec_exists = Speciality::with('projects')->whereIn('speciality_name', $specs)->pluck('speciality_name')->toArray();
        //foreach specs add the specialities that is not recorded in the database
        foreach($specs as $spec) {
            $speciality = new Speciality;
            if(!in_array($spec, $spec_exists)) {
                $speciality->speciality_name = $spec;
                $speciality->save();
                //make the speciality sluggable
                $sluggable = $speciality->replicate();
            }
        }
        // redirect to the home page
        session()->flash('success', 'Your speciality has been created.');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function edit(Speciality $speciality)
    {
        return view('admin.speciality.edit', compact('speciality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speciality $speciality)
    {   

        $spec_exists = Speciality::with('projects')->where('speciality_name', $request['speciality_name'])->pluck('speciality_name')->toArray();

        if(!in_array($request['speciality_name'], $spec_exists)) {

            $speciality->speciality_name = $request['speciality_name'];

            $speciality->update();

            // redirect to the home page
            session()->flash('success', 'Your speciality has been updated.');

        }else {
            session()->flash('success', 'Sepciality already exists.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speciality $speciality)
    {
        //
    }
}
