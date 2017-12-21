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
        $this->validate($request, [
            'speciality_name' => 'required|string|max:255',
            'slug' => 'unique:specialities'
        ]);

        $speciality = new Speciality;

        $speciality->speciality_name = $request['speciality_name'];

        //save it to the database 
        $speciality->save();
        //make the speciality sluggable
        $sluggable = $speciality->replicate();
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
        //
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
        //
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
