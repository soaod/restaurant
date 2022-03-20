<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTableTypeRequest;
use App\Http\Requests\UpdateTableTypeRequest;
use App\Models\TableType;

class TableTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreTableTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTableTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TableType  $tableType
     * @return \Illuminate\Http\Response
     */
    public function show(TableType $tableType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TableType  $tableType
     * @return \Illuminate\Http\Response
     */
    public function edit(TableType $tableType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTableTypeRequest  $request
     * @param  \App\Models\TableType  $tableType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTableTypeRequest $request, TableType $tableType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TableType  $tableType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TableType $tableType)
    {
        //
    }
}
