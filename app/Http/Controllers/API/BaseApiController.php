<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected array $response = array(
        'status' => "",
        'message' => "",
        'code' => 0
    );

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse(int $code = 200): JsonResponse
    {
        if ($this->response["status"] == "") {
            $this->response["status"] = "success";
        }
        return response()->json($this->response, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function badRequestResponse(int $code = 400): JsonResponse
    {
        if ($this->response['message'] == "") {
            $this->response["message"] = "Please Check Your Request Parameters.";
        }
        if ($this->response["status"] == "") {
            $this->response["status"] = "error";
        }
        return response()->json($this->response, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function unauthorizedResponse(int $code = 403): JsonResponse
    {
        if ($this->response['message'] == "") {
            $this->response["message"] = "Unauthorized Access.";
        }
        if ($this->response["status"] == "") {
            $this->response["status"] = "error";
        }
        return response()->json($this->response, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function unauthenticatedResponse(int $code = 401): JsonResponse
    {

        if ($this->response['message'] == "") {
            $this->response["message"] = "Unauthenticated User.";
        }
        if ($this->response["status"] == "") {
            $this->response["status"] = "error";
        }
        return response()->json($this->response, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function internalErrorResponse(int $code = 500): JsonResponse
    {
        if ($this->response['message'] == "") {
            $this->response["message"] = "Internal Error Please Try Again Later.";
        }
        if ($this->response["status"] == "") {
            $this->response["status"] = "error";
        }
        return response()->json($this->response, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function notfoundErrorResponse(int $code = 404): JsonResponse
    {
        if ($this->response['message'] == "") {
            $this->response["message"] = "Resource Not Found.";
        }
        if ($this->response["status"] == "") {
            $this->response["status"] = "error";
        }
        return response()->json($this->response, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    protected function customErrorResponse(int $code = 201): JsonResponse
    {
        if ($this->response['message'] == "") {
            $this->response["message"] = "";
        }
        if ($this->response["status"] == "") {
            $this->response["status"] = "error";
        }
        return response()->json($this->response, $code);
    }
}
