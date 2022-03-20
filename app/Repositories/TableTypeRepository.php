<?php

namespace App\Repositories;

use App\Models\TableType;

class TableTypeRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new TableType()));
    }
}
