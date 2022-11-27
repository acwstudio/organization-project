<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\Regions\RegionRelationsRepository;
use App\Repositories\Api\Regions\RegionsFederalDistrictRelationsRepository;
use App\Services\Api\AbstractCRUDService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionsFederalDistrictRelationsService
{
    protected RegionRelationsRepository $regionRelationsRepository;

    /**
     * @param RegionRelationsRepository $regionRelationsRepository
     */
    public function __construct(RegionRelationsRepository $regionRelationsRepository)
    {
        $this->regionRelationsRepository = $regionRelationsRepository;
    }

    /**
     * @param array $data
     * @return HasMany
     */
    public function indexRelations(array $data): BelongsTo
    {
        return $this->regionRelationsRepository->indexRelations($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        $this->regionRelationsRepository->updateRelations($data);
    }
}
