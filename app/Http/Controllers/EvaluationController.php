<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\TpeCategories;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class EvaluationController extends Controller
{
    public function __construct(){
        $TpeQuestions = Evaluation::with('category')->get();
        $TpeCategoriesList = TpeCategories::get()->lists('tpe_category','id')->all();


        view()->share(compact([
            'TpeCategoriesList',
            'TpeQuestions'
        ]));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $TpeCategories = TpeCategories::all();
        $TpeQuestions = Evaluation::all();

        return view('tpe.tpe', compact([
            'TpeCategories',
            'TpeQuestions'
        ]));
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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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

    public function insertTPECategory(Request $request){
        TpeCategories::create($request->all());
        return Redirect::to("/tpe");
    }

    public function insertTPEQuestion( Request $request ){
        Evaluation::create($request->all());
        return Redirect::to("/tpe")->withInput($request->except('tpe_question'));
    }
}
