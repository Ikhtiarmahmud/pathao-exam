<?php

namespace App\Services\V1;

use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        private readonly OrderRepository $repository
    ) {}

    public function getOrders()
    {
        return $this->repository->findAll();
    }

    public function store($request)
    {
        $data = $request->all();

        return $this->repository->create($data);
    }
}
