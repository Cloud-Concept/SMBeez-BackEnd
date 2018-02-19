<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

use Carbon\Carbon;

use DB;

use App\Company;

class ExcelController extends Controller

{

	/**

     * Create a new controller instance.

     *

     * @return void

     */

    public function importExportView(){

        return view('layouts.import_export');

    }



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function importFile(Request $request){

        if($request->hasFile('sample_file')){

            $path = $request->file('sample_file')->getRealPath();

            $data = \Excel::load($path)->get();



            if($data->count()){

                foreach ($data as $key => $value) {

                	$slug = SlugService::createSlug(Company::class, 'slug', $value->company_name, ['unique' => true]);

                    $arr[] = ['company_name' => $value->company_name,
                     'location' => $value->location,
                     'slug' 	=> $slug,
                     'company_phone' => $value->company_phone,
                     'company_email' => $value->company_email,
                     'company_website' => $value->company_website,
                     'year_founded' => $value->year_founded,
                     'company_size' => $value->company_size,
                     'company_description' => $value->company_description,
                     'city' => $value->city,
                     'industry_id' => $value->industry_id,
                     'user_id' => 0,
                     'status' => 1,
                     'created_at' => Carbon::now(),
                     'updated_at' => Carbon::now(),
                     ];

                }

                if(!empty($arr)){

                    DB::table('companies')->insert($arr);

                    session()->flash('success', 'File successfully imported.');

                }

            }

        }

        session()->flash('error', 'Request data does not have any files to import.');

        return back();      

    } 



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function exportFile($type){

        $companies = Company::get()->toArray();



        return \Excel::create('companies_sheet', function($excel) use ($companies) {

            $excel->sheet('Companies Sheet', function($sheet) use ($companies)

            {

                $sheet->fromArray($companies);

            });

        })->download($type);

    }      

}