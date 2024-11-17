<?php

namespace App\Response;

use App\Enums\ApiCustomStatusCode;
use App\Enums\HttpStatusCode;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function sendSuccessResponse(
        $result,
        $message,
        $pagination = [],
        $http_status = HttpStatusCode::SUCCESS,
        $status_code = ApiCustomStatusCode::SUCCESS
    ): JsonResponse {
        $response = [
            'status' => 'SUCCESS',
            'status_code' => $status_code,
            'message' => $message,
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        if (!empty($pagination)) {
            $response ['pagination'] = $pagination;
        }

        return response()->json($response, $http_status)->withHeaders([]);
    }

    public static function sendErrorResponse($message, $errorMessages = [], $status_code = HttpStatusCode::VALIDATION_ERROR): JsonResponse
    {
        $errorCode = $errorMessages['code'] ?? '';

        if ($errorCode) {
            $errorCode = $errorCode . ': ';
        }

        $response = [
            'status' => 'FAIL',
            'status_code' => $status_code,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            if (!empty($errorMessages['message'])) {
                $errorMessages['message'] = $errorCode . $errorMessages['message'];
            }

            $response['error'] = $errorMessages;
        }

        return response()->json($response, $status_code);
    }

}
