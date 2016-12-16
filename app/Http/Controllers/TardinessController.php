<?php

namespace App\Http\Controllers;

use App\Student;
use App\Tardiness;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TardinessController extends Controller
{


    public function __construct(){
        $Students = Student::orderBy('student_name')->get()->lists('student_name','id')->all();

        view()->share(compact([
            'Students'
        ]));
    }

    /**
     * Display a listing of the resource.
     *`
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Tardiness = Tardiness::all();

        return view('tardiness.tardiness',compact([
            'Tardiness'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Tardiness = new Tardiness();

        return view('tardiness.tardiness_edit',compact([
            'Tardiness'
        ]));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id');


        $form_data = $request->all();

        if ( Tardiness::find($id) == null ) {
            $form_data['date_filed'] = Carbon::now();
        }


        $messages = [
            'student_id.required' => 'Please select a Student',
        ];

        $rules = [
            'student_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'reason' => 'required',
        ];

        $this->validate($request,$rules,$messages);

        $Tardiness = Tardiness::firstOrCreate([
            'id' => $id
        ]);

        $Tardiness->update($form_data);

        return Redirect::to("tardiness/". $Tardiness->id ."/edit");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Tardiness = Tardiness::find($id);

        return view('tardiness.tardiness_edit', compact([
            'Tardiness'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
