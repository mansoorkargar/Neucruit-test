<?php

declare (strict_types = 1);

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Get all recources
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find recource by id 
     *
     * @param  int|string $id
     * @return Collection
     */
    public function find(int|string $id): Model;

    /**
     * Create a new recource
     *
     * @param Request $request
     * @return Collection
     */
    public function create(Request $request): Model;

    /**
     * Update recource by id
     *
     * @param Request $request
     * @param  int|string $id
     * @return Collection
     */
    public function update(Request $request, int|string $id): Model;

    /**
     * Delete recource by id
     *
     * @param  int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
