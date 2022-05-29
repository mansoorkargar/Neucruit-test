<?php

declare (strict_types = 1);

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Abstract Repository class with default CRUD methods
 */
class AbstractRepository implements RepositoryInterface
{
    /**
     * Eloquent model instance
     *
     * @var Model $model
     */
    protected $model;

    /**
     * Load default class dependencies.
     *
     * @param Model $model Illuminate\Database\Eloquent\Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all recources
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->get();
    }

    /**
     * Find recource by id 
     *
     * @param  int|string $id
     * @return Model
     */
    public function find(int|string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new recource
     *
     * @param Request $request
     * @return Model
     */
    public function create(Request $request): Model
    {
        $data = $request->all();
        $item = new $this->model;
        $item->fill($data);
        $item->save();

        return $item->fresh();
    }

    /**
     * Update recource by id
     *
     * @param Request $request
     * @param  int|string $id
     * @return Model
     */
    public function update(Request $request, int|string $id): Model
    {
        $data = $request->all();
        $item = $this->find($id);
        $item->fill($data);
        $item->save();

        return $item;
    }

    /**
     * Delete recource by id
     *
     * @param  int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return (bool) $this->model->destroy($id);
    }
}
