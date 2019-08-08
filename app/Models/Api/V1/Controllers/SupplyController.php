<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\TechServiceRequest as Request;
use App\CleaningService;
use App\Supply;
use App\Tech;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Supply::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Supply();
        $model->fill($request->all());
        $model->user_id = auth()->id();
        $model->save();
        return response()->json($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Supply::findOrFail($id);
    }
}
