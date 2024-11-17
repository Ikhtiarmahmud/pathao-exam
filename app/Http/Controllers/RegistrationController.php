<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use App\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\V1\RegistrationService;

class RegistrationController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrationService
    ) {}

    public function login(Request $request): JsonResponse
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        try {
            $result = $this->registrationService->loginWithPassword($data);

            return ApiResponse::sendSuccessResponse($result, 'Login Successfully');
        } catch (\Exception $e) {
            return ApiResponse::sendErrorResponse('Login Failed', (array) $e, HttpStatusCode::INTERNAL_ERROR);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();

            return ApiResponse::sendSuccessResponse([], 'Successfully logged out');
        } catch (\Exception $e) {
            return ApiResponse::sendErrorResponse('Logout Failed', (array) $e, HttpStatusCode::INTERNAL_ERROR);
        }
    }
}
