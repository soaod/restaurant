<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreRestaurantSettingRequest;
use App\Http\Requests\UpdateRestaurantSettingRequest;
use App\Models\RestaurantSetting;

class RestaurantSettingController extends BaseApiController
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
     * @param \App\Http\Requests\StoreRestaurantSettingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestaurantSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\RestaurantSetting $restaurantSetting
     * @return \Illuminate\Http\Response
     */
    public function show(RestaurantSetting $restaurantSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\RestaurantSetting $restaurantSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(RestaurantSetting $restaurantSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateRestaurantSettingRequest $request
     * @param \App\Models\RestaurantSetting $restaurantSetting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRestaurantSettingRequest $request, RestaurantSetting $restaurantSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RestaurantSetting $restaurantSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(RestaurantSetting $restaurantSetting)
    {
        //
    }
}
