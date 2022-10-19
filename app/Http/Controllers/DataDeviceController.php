<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataDeviceRequest;
use App\Http\Requests\UpdateDataDeviceRequest;
use App\Models\DataDevice;

class DataDeviceController extends Controller
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
     * @param  \App\Http\Requests\StoreDataDeviceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataDeviceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataDevice  $dataDevice
     * @return \Illuminate\Http\Response
     */
    public function show(DataDevice $dataDevice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataDevice  $dataDevice
     * @return \Illuminate\Http\Response
     */
    public function edit(DataDevice $dataDevice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDataDeviceRequest  $request
     * @param  \App\Models\DataDevice  $dataDevice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDataDeviceRequest $request, DataDevice $dataDevice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataDevice  $dataDevice
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataDevice $dataDevice)
    {
        //
    }
}
