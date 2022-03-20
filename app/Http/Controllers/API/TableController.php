<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreTableRequest;
use App\Http\Resources\Table\TableResource;
use App\Models\Table;
use App\Repositories\TableRepository;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;

class TableController extends BaseApiController
{
    private TableRepository $tableRepository;

    public function __construct(TableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tables = $this->tableRepository->pagination();
        $this->response['tables'] = TableResource::collection($tables);
        $this->response['total'] = $tables->total();
        $this->response['lastPage'] = $tables->lastPage();
        $this->response['currentPage'] = $tables->currentPage();
        return $this->successResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTableRequest $request
     * @return JsonResponse
     */
    public function store(StoreTableRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $this->response['message'] = "Table Was Added Successfully";
            $this->response['table'] = new TableResource($this->tableRepository->customCreate($validated));
            return $this->successResponse();
        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Table $table
     * @return JsonResponse
     */
    public function destroy(Table $table): JsonResponse
    {
        try {
            if ($table->reservations()->count() > 0) {
                $this->response['message'] = "Table With Reservations Can Not Be Deleted.";
                return $this->badRequestResponse();
            }

            $this->tableRepository->deleteById($table->id);
            $this->response['message'] = "Table Deleted Successfully";
            return $this->successResponse();
        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }
}
