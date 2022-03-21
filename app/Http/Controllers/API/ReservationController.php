<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use App\Repositories\TableRepository;
use App\Repositories\TableTypeRepository;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;

class ReservationController extends BaseApiController
{

    private ReservationRepository $reservationRepository;
    private TableTypeRepository $tableTypeRepository;
    private TableRepository $tableRepository;

    public function __construct(ReservationRepository $reservationRepository, TableTypeRepository $tableTypeRepository, TableRepository $tableRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->tableTypeRepository = $tableTypeRepository;
        $this->tableRepository = $tableRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $conditions = [];
            if (request()->query("from")) {
                $conditions[] = [
                    "date", ">=", request()->query("from")
                ];
            }

            if (request()->query("to")) {
                $conditions[] = [
                    "date", "<=", request()->query("to")
                ];
            }

            if (request()->query("table")) {
                $conditions[] = [
                    "table_id", "<=", request()->query("table")
                ];
            }

            $reservations = $this->reservationRepository->pagination(conditions: $conditions);
            $this->response['reservations'] = ReservationResource::collection($reservations);
            $this->response['total'] = $reservations->total();
            $this->response['currentPage'] = $reservations->currentPage();
            $this->response['lastPage'] = $reservations->lastPage();

            return $this->successResponse();
        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function today(): JsonResponse
    {
        try {
            $conditions = [];

            $conditions[] = [
                "date", date("Y-m-d")
            ];
            $reservations = $this->reservationRepository->pagination(conditions: $conditions);
            $this->response['reservations'] = ReservationResource::collection($reservations);
            $this->response['total'] = $reservations->total();
            $this->response['currentPage'] = $reservations->currentPage();
            $this->response['lastPage'] = $reservations->lastPage();

            return $this->successResponse();
        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReservationRequest $request
     * @return JsonResponse
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();


            if ( date("H:i:s", strtotime($validated["starting_time"])) < date("H:i:s", strtotime("12:00:00 pm"))) {
                $this->response['message'] = "Starting Time Is Before Restaurant Open Time";
                return $this->badRequestResponse();
            }

            if ( date("H:i:s", strtotime($validated["ending_time"])) > date("H:i:s", strtotime("11:59:00 pm"))) {
                $this->response['message'] = "Ending Time Is After Restaurant Open Time";
                return $this->badRequestResponse();
            }

            if ( $this->reservationRepository->checkReservation(tableId: $validated['table'], startingTime: $validated['starting_time'], endingTime: $validated['ending_time']) ) {
                $this->response['message'] = "There Is Reservation Overlapping, Please Change The Times And Try Again.";
                return $this->badRequestResponse();
            }

            $result = $this->reservationRepository->customCreate($validated);

            if ( $result['status'] === "success" ) {
                $this->response['message'] = "Reservation Saved Successfully";
                return $this->successResponse();
            }

            $this->response['message'] = $result["message"];
            return $this->badRequestResponse();
        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        try {

            if ($reservation->date->format("Y-m-d") < date("Y-m-d")) {
                $this->response['message'] = "Reservations In The Past Can Not Be Deleted";
                return $this->badRequestResponse();
            }

            $reservation->delete();

            $this->response['message'] = "Reservation Was Deleted Successfully";
            return $this->successResponse();
        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }

    /**
     * @return JsonResponse
     */
    public function checkTimeSlots(): JsonResponse
    {
        $requiredSeats = request()->query("seats");

        if ($requiredSeats === null) {
            $this->response['message'] = "'seats' Parameter Is Required";
            return $this->badRequestResponse();
        }

        if (!filter_var($requiredSeats, FILTER_VALIDATE_INT)) {
            $this->response['message'] = "'seats' Parameter Must Be Integer And Grater Than 0";
            return $this->badRequestResponse();
        }

        $maximumSeats = $this->tableTypeRepository->maxTableSeats();

        if ($requiredSeats > $this->tableTypeRepository->maxTableSeats()) {
            $this->response['message'] = "Maximum Seats Available Is {$maximumSeats}";
            return $this->badRequestResponse();
        }

        $minimumAllowedSeats = $this->tableTypeRepository->getMinimumSeats($requiredSeats);
        $tables = $this->tableRepository->searchAvailableTables($requiredSeats, $minimumAllowedSeats);
        $timeSlots = $this->tableRepository->getTimeSlots($tables);
        $this->response['tables'] = $timeSlots;
        $this->response['total'] = count($timeSlots);

        return $this->successResponse();
    }
}
