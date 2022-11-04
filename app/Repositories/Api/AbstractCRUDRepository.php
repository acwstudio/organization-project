<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractCRUDRepository
{
    /**
     * @return QueryBuilder
     */
    abstract public function index(): QueryBuilder;

    /**
     * @param array $attributes
     * @return Model
     */
    abstract public function store(array $attributes): Model;

    /**
     * @param int $id
     * @return QueryBuilder
     */
    abstract public function show(int $id): QueryBuilder;

    /**
     * @param array $attributes
     * @param int $id
     * @return void
     */
    abstract public function update(array $attributes, int $id): void;

    /**
     * @param int $id
     * @return void
     */
    abstract public function destroy(int $id): void;
}
