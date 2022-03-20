<?php

namespace App\Http\Resources\Table;

use App\Http\Resources\TableType\TableTypeResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'type' => new TableTypeResource($this->tableType),
            'isActive' => $this->isActive
        ];
    }
}
