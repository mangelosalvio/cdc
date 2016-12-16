<?php

namespace App\Http\Controllers;

use App\College;
use App\Company;
use App\MoaCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $Company = new Company();
        $Companies = Company::orderBy('company_name')->get();
        //$Companies = Company::whereId(1)->orderBy('company_name')->get();

        $MoaCategories = MoaCategory::get()->lists('name', 'id')->all();

        return view('company.company_edit',compact(['Company','Companies','MoaCategories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ( $request->has('company_name') ) {
            Company::create([
                'company_name' => $request->input('company_name'),
                'address' => $request->input('address'),
                'company_contact_person' => $request->input('company_contact_person'),
                'company_contact_no' => $request->input('company_contact_no'),
                'position' => $request->input('position'),
                'nature_of_business' => $request->input('nature_of_business')
            ]);
        }

        if ( count( $request->input('arr_id') ) ) {

            foreach ( $request->input('arr_id') as $i => $id ) {
                Company::find($id)
                    ->update([
                        'company_name' => $request->input('arr_company_name')[$i],
                        'address' => $request->input('arr_address')[$i],
                        'company_contact_person' => $request->input('arr_company_contact_person')[$i],
                        'company_contact_no' => $request->input('arr_company_contact_no')[$i],
                        'position' => $request->input('arr_position')[$i],
                        'nature_of_business' => $request->input('arr_nature_of_business')[$i]
                    ]);

                /**
                 * Check for checkboxes
                 * LOOP THROUGH EACH COLLEGE
                 */

                /*$Company = Company::find($id);
                $Company->colleges()->detach();

                if ( $request->input('arr_is_engg')[$i] == 1 ) {
                    $Company->colleges()->attach(1);

                }


                $Company = Company::find($id);
                if ( $request->input('arr_is_hm')[$i] == 1 ) {
                    $Company->colleges()->attach(2);
                }


                $Company = Company::find($id);
                if ( $request->input('arr_is_cba')[$i] == 1 ) {
                    $Company->colleges()->attach(3);

                }

                set_time_limit(30);*/

            }
        }


        return Redirect::to('company');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function printReport()
    {
        $Companies = Company::orderBy('company_name')
            ->whereId(32)
            ->whereHas('students', function($q){
                $q->where('internship_taken_id','=',3);
            })
            ->get();



        return view('reports.companies',compact([
            'Companies'
        ]));
    }
    public function updateCollege(Request $request)
    {
        if ( $request->input('is_checked') == 1 ) {
            Company::findOrNew($request->input('company_id'))
                ->colleges()
                ->attach($request->input('college_id'));
        } else {
            Company::findOrNew($request->input('company_id'))
                ->colleges()
                ->detach($request->input('college_id'));
        }
    }

    public function deleteCompany(Request $request)
    {

    }

    public function updateMoaCategory(Request $request){
        $Company = Company::find($request->input('company_id'));

        $Company->moa_category_id = $request->input('moa_category_id');
        $Company->save();
    }
}
