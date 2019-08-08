<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CleaningServiceRequest as Request;
use App\CleaningService;
use App\Http\Controllers\Controller;
use App\Services\FileUploader;


class CleaningServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CleaningService::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $model = new CleaningService();
        $model->fill($request->all());
        $model->user_id = auth()->id();
        if($request->hasFile('photo')) {
            /** @var FileUploader $uploader */
            $uploader = app(FileUploader::class);
            $filePath = $uploader->upload($request->file('photo'));
            $model->photo = $filePath;
        }
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
        return CleaningService::findOrFail($id);
    }
}
