<?php

namespace App\Repositories;

use App\Models\TableType;
use Illuminate\Database\Eloquent\Model;

class TableTypeRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new TableType()));
    }

    /**
     * @return int
     */
    public function maxTableSeats(): int
    {
        return $this->model->max("seats");
    }

    /**
     * @param int $requiredSeats
     * @return int
     */
    public function getMinimumSeats(int $requiredSeats): int
    {
        return $this->model->where("seats", ">=", $requiredSeats)->min("seats");
    }
}
