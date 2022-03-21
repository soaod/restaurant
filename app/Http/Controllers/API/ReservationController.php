<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;

class ReservationController extends BaseApiController
{

    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
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
        //
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
}
