<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryContract
{
    protected string $modelName;
    protected Model $model;

    public function __construct()
    {
        $this->setModel();
    }

    public function setModel(): void
    {
        if (class_exists($this->modelName)) {
            $this->model = new $this->modelName();
        } else {
            throw new Exception('No model name defined');
        }
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function findOne($id, $relation = null): ?Model
    {
        return $this->findOneBy(['id' => $id], $relation);
    }

    public function findOrFail($id, $relation = null, array $orderBy = null)
    {
        return $this->prepareModelForRelationAndOrder($relation, $orderBy)->findOrFail($id);
    }

    public function findBy(array $searchCriteria = [], $relation = null, array $orderBy = null, $select = null)
    {
        $model = $this->prepareModelForRelationAndOrder($relation, $orderBy);
        $limit = ! empty($searchCriteria['per_page']) ? (int) $searchCriteria['per_page'] : 15;

        $queryBuilder = $model->where(function ($query) use ($searchCriteria) {
            $this->applySearchCriteriaInQueryBuilder($query, $searchCriteria);
        });

        if (!empty($searchCriteria['per_page'])) {
            return $queryBuilder->paginate($limit);
        }

        if (!is_null($select)) {
            $queryBuilder = $queryBuilder->select($select);
        }

        return $queryBuilder->get();
    }

    public function findIn($key, array $values, $relation = null, array $orderBy = null)
    {
        return $this->prepareModelForRelationAndOrder($relation, $orderBy)->whereIn($key, $values)->get();
    }

    public function findAll($perPage = null, $relation = null, array $orderBy = null)
    {
        $model = $this->prepareModelForRelationAndOrder($relation, $orderBy);
        if ($perPage) {
            return $model->paginate($perPage);
        }

        return $model->get();
    }

    public function findByProperties(array $params, array $fields = ['*'])
    {
        $query = $this->model->query();

        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get($fields);
    }

    public function findOneByProperties(array $params, array $fields = ['*'])
    {
        $query = $this->model->query();

        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }

        return $query->first($fields);
    }

    public function findOneBy(array $criteria, $relation = null)
    {
        return $this->prepareModelForRelationAndOrder($relation)->where($criteria)->first();
    }

    public function findLatestOne(array $criteria, array $relation = null)
    {
        return $this->prepareModelForRelationAndOrder($relation)->where($criteria)->latest()->first();
    }

    public function findByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function saveMany($resources)
    {
        DB::transaction(function () use ($resources) {
            foreach ($resources as $resource) {
                $this->save($resource);
            }
        });
    }

    public function update($resource, $data = [])
    {
        if (is_array($data) && count($data) > 0) {
            $resource->fill($data);
        }

        $this->save($resource);

        return $resource;
    }

    public function delete($resource)
    {
        $resource->delete();

        return $resource;
    }

    public function create(array $properties)
    {
        if (count($properties)) {
            return $this->model->create($properties);
        }

        return null;
    }

    private function prepareModelForRelationAndOrder($relation, array $orderBy = null)
    {
        $model = $this->model;
        if ($relation) {
            $model = $model->with($relation);
        }
        if ($orderBy) {
            $model = $model->orderBy($orderBy['column'], $orderBy['direction']);
        }

        return $model;
    }

    /**
     * Apply condition on query builder based on search criteria
     *
     * @param  object  $queryBuilder
     * @return mixed
     */
    protected function applySearchCriteriaInQueryBuilder($queryBuilder, array $searchCriteria = [])
    {

        foreach ($searchCriteria as $key => $value) {

            //skip pagination related query params
            if (in_array($key, ['page', 'per_page'])) {
                continue;
            }

            //we can pass multiple params for a filter with commas
            $allValues = explode(',', $value);

            if (count($allValues) > 1) {
                $queryBuilder->whereIn($key, $allValues);
            } else {
                $operator = '=';
                $queryBuilder->where($key, $operator, $value);
            }
        }

        return $queryBuilder;
    }
}
