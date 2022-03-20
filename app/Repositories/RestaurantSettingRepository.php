<?php

namespace App\Repositories;

use App\Models\RestaurantSetting;

class RestaurantSettingRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new RestaurantSetting()));
    }
}
