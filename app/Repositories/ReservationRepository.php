<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;

class ReservationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new Reservation()));
    }

    /**
     * @param array $data
     * @return array
     */
    public function customCreate(array $data): array
    {
        $result = [
            "status" => "error",
            "message" => ""
        ];

        $createData = [
            "table_id" => $data['table'],
            "from" => $data["starting_time"],
            "to" => $data["ending_time"],
            "customer_id" => 1,
            "user_id" => auth("api")->id(),
            "date" => date("Y-m-d")
        ];

        $this->create($createData);
        $result["status"] = "success";
        return $result;
    }

    /**
     * @param int $tableId
     * @param string $startingTime
     * @param string $endingTime
     * @return bool
     */
    public function checkReservation(int $tableId, string $startingTime, string $endingTime): bool
    {

        return $this->model
            ->where("table_id", $tableId)
            ->whereDate("date", date("Y-m-d"))
            ->where(function (Builder $builder) use ($startingTime, $endingTime) {
                $builder
                    ->whereTime("from", $startingTime)
                    ->whereTime("to", $endingTime);
            })->orWhere(function (Builder $builder) use ($startingTime, $endingTime) {
                $builder
                    ->whereTime("from", "<", $startingTime)
                    ->whereTime("to", ">", $endingTime);
            })->orWhere(function (Builder $builder) use ($startingTime, $endingTime) {
                $builder
                    ->whereTime("from", "<", $startingTime)
                    ->whereTime("from", "<", $endingTime)
                    ->whereTime("to", ">", $startingTime)
                    ->whereTime("to", ">", $endingTime);
            })->count() > 0;
    }
}
