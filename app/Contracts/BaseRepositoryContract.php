<?php

namespace App\Contracts;

interface BaseRepositoryContract
{
    public function findOne($id, $relation);

    public function findOneBy(array $criteria, $relation);

    public function findBy(array $searchCriteria = [], $relation = null, array $orderBy = null);

    public function findIn($key, array $values, $relation = null, array $orderBy = null);

    public function findAll($perPage = null, $relation = null, array $orderBy = null);

    public function findOrFail($id, $relation = null, array $orderBy = null);

    public function findByProperties(array $params, array $fields = ['*']);

    public function findOneByProperties(array $params, array $fields = ['*']);

    public function findByIds($ids);

    public function getAll();

    public function save(array $data);

    public function saveMany($resources);

    public function update($resource, $data = []);

    public function delete($resource);

    public function getModel();

    public function create(array $properties);
}
