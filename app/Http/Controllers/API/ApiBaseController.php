<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiBaseController extends Controller
{
    protected ?int $userId;
    protected ?User $user;

    public function __construct()
    {
        $this->userId = auth('api')->id();
        $this->user = auth('api')->user();
    }

    public function checkOwnership($model): bool
    {
        if (isset($model->user_id)) {
            return $model->user_id === $this->user->id;
        }

        return true;
    }

    public function checkShared(Trip $trip): bool
    {
        if (isset($trip->shared)) {
            return $trip->shared === true;
        }

        return false;
    }

    public function unauthorizedResponse()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function createResponse($data): JsonResponse
    {
        $status = !is_null($data);
        $responseSuccess = ResponseAlias::HTTP_CREATED;
        $responseError = ResponseAlias::HTTP_BAD_REQUEST;

        return response()->json([
            'status' => $status ? 'success' : 'error',
            'data' => $data
        ], $status ? $responseSuccess : $responseError);
    }

    public function showResponse($data): JsonResponse
    {
        $status = !is_null($data);
        $responseSuccess = ResponseAlias::HTTP_OK;
        $responseError = ResponseAlias::HTTP_BAD_REQUEST;

        return response()->json([
            'status' => $status ? 'success' : 'error',
            'data' => $data
        ], $status ? $responseSuccess : $responseError);
    }

    public function updateResponse($status, $data): JsonResponse
    {
        $responseSuccess = ResponseAlias::HTTP_OK;
        $responseError = ResponseAlias::HTTP_BAD_REQUEST;

        return response()->json([
            'status' => $status ? 'success' : 'error',
            'data' => $data
        ], $status ? $responseSuccess : $responseError);
    }

    public function deleteResponse($status): JsonResponse
    {
        $responseSuccess = ResponseAlias::HTTP_OK;
        $responseError = ResponseAlias::HTTP_BAD_REQUEST;

        return response()->json([
            'status' => $status ? 'success' : 'error',
        ], $status ? $responseSuccess : $responseError);
    }
}
