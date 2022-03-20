<?php

namespace App\Repositories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Model;

class TableRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new Table()));
    }

    public function pagination(int $length = 10)
    {
        return $this->model->paginate($length);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function customCreate(array $data): Model
    {
        $creationData = [
            'number' => $data['number'],
            'table_type_id' => $data['type']
        ];

        return $this->create($data);
    }
}
