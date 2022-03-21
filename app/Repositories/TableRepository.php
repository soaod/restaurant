<?php

namespace App\Repositories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class TableRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new Table()));
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

        return $this->create($creationData);
    }

    /**
     * @param int $requiredSeats
     * @param int $minimumAllowedSeats
     * @return Collection
     */
    public function searchAvailableTables(int $requiredSeats, int $minimumAllowedSeats): Collection
    {
        return $this->model
            ->whereHas("tableType", function (Builder $builder) use ($requiredSeats, $minimumAllowedSeats) {
                $builder
                    ->where("seats", $requiredSeats)
                    ->orWhere("seats", $minimumAllowedSeats);
            })
            ->whereDoesntHave("reservations")
            ->orWhereHas("reservations", function (Builder $builder) {
                $builder->whereDate("date", date("Y-m-d"))
                    ->whereTime("to", ">=", date("H-m-s"));
            })
            ->get();

    }

    /**
     * @param Collection $tables
     * @return array
     */
    public function getTimeSlots(Collection $tables): array
    {
        $timeSlots = [];
        foreach ($tables as $key => $table) {
            $timeSlots[$key] = [
                "number" => $table->number,
                "seats" => $table->tableType->seats,
                "slots" => []
            ];
            if ( $table->reservations()->count() > 0 ) {
                $from = [];
                $to = [];
                foreach ($table->reservations as $reservation) {
                    array_push($from,$reservation->from);
                    array_push($to, $reservation->to);
                }
                sort($from);
                sort($to);

                array_push($from, "11:59:00");
                array_shift($from);

                foreach ($to as $innerKey => $t) {
                    array_push($timeSlots[$key]["slots"], "$t - $from[$innerKey]");
                }

            } else {
                $timeSlots[$key]["slots"] = [
                    "12:00 pm - 11:59 pm"
                ];
            }
        }
        return $timeSlots;
    }
}
