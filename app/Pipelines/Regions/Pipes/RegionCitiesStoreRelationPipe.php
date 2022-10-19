<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRepository;

final class RegionCitiesStoreRelationPipe
{
    protected RegionRepository $regionRepository;

    /**
     * @param RegionRepository $regionRepository
     */
    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        // to do something

        return $next($data);
    }
}
