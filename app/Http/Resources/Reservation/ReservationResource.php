<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Table\TableResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ReservationResource extends JsonResource
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
            'employee' => new UserResource($this->user),
            'customer' => new CustomerResource($this->customer),
            'table' => new TableResource($this->table),
            'date' => $this->date,
            'form' => $this->form,
            'to' => $this->to,
            'total_people' => $this->total_people,
        ];
    }
}
