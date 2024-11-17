<?php

namespace App\Services\V1;

use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        private readonly OrderRepository $repository
    ) {}

    public function getOrders()
    {
        return $this->repository->findBy(['user_id' => Auth::id()]);
    }

    public function store($request)
    {
        $data = $request->all();

        $data['user_id'] = Auth::id();

        return $this->repository->create($data);
    }
}
