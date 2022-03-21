<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends BaseApiController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {

            $users = $this->userRepository->pagination();
            $this->response['users'] = UserResource::collection($users);
            $this->response['total'] = $users->total();
            $this->response['currentPage'] = $users->currentPage();
            $this->response['lastPage'] = $users->lastPage();

            return $this->successResponse();

        } catch (Exception | Error $exception) {
            return $this->internalErrorResponse();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $this->response['user'] = new UserResource($this->userRepository->customCreate($validated));
            $this->response['message'] = "User Was Added Successfully";

            return $this->successResponse();

        } catch (Exception | Error $exception) {
            $this->response['message'] = $exception->getMessage();
            return $this->internalErrorResponse();
        }
    }
}
