<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityRepository;

final class CityStorePipe
{
    protected CityRepository $cityRepository;

    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $attributes = data_get($data, 'data.attributes');

        $model = $this->cityRepository->store($attributes);

        $data = data_set($data, 'model', $model);

        return $next($data);
    }
}
