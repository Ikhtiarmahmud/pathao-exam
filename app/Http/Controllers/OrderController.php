<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use App\Response\ApiResponse;
use App\Services\V1\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service
    ) {}

    public function getOrders(): JsonResponse
    {
        try {
            $result = $this->service->getOrders();

            return ApiResponse::sendSuccessResponse($result, 'Orders Successfully Fetched');
        } catch (\Exception $e) {
            return ApiResponse::sendErrorResponse('Something went wrong', [], HttpStatusCode::INTERNAL_ERROR);
        }
    }
    
    public function store(OrderRequest $request): JsonResponse
    {
        try {
            $result = $this->service->store($request);

            return ApiResponse::sendSuccessResponse($result, 'Order Created Successfully');
        } catch (\Exception $e) {
            return ApiResponse::sendErrorResponse('Something went wrong', [], HttpStatusCode::INTERNAL_ERROR);
        }
    }
}
