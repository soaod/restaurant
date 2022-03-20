<?php

namespace App\Repositories;

use App\Models\Table;

class TableRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new Table()));
    }
}
