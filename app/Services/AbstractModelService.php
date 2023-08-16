<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractModelService
{
    protected $model;

    public function create(array $attributes): bool
    {
        return $this->model->fill($attributes)->save();
    }

    public function update(Model $model, $params): bool
    {
        $this->model = $model;

        return $this->model->update($params);
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function destroy(int $id)
    {
        return $this->getById($id)->delete();
    }

    public function all()
    {
        return $this->model->get();
    }

    public function getWithPaginate(Request $request, int $perPage = 10, int $currentPage = 0)
    {
        return $this->model->paginate($perPage);
    }
}
