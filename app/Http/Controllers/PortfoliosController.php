<?php

namespace App\Http\Controllers;

use App\Portfolio;
use App\Company;
use Illuminate\Http\Request;

class PortfoliosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {   

        $this->validate($request, [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'portfolio-img' => 'mimes:jpeg,jpg,png|max:5000'

        ]);

        $portfolio = new Portfolio;

        $portfolio->company_id = $company->id;
        $portfolio->title = $request['title'];
        $portfolio->description = $request['description'];

        if($request->hasFile('portfolio-img')) {

            $file = $request->file('portfolio-img');

            $filefullname = $file->getClientOriginalName();
            $filename = time() . '-' . str_slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            //store in the storage folder
            $file->storeAs('/', $filename, 'company_files');

            $portfolio->file_name = $filefullname;
            $portfolio->file_path = $filename;

        }

        $portfolio->save();

        $company->addRelevanceScore(5, $company->id);
        session()->flash('success', __('company.portfolio_add_msg'));
        event(new \App\Events\AddPoints($portfolio->company->id, 'add-portfolio', 'monthly'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Portfolio $portfolio)
    {
        $portfolio->delete();

        return back();
    }
}
