<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\FederalDistrict;
use App\Repositories\Api\Regions\RegionsFederalDistrictRelationsRepository;
use App\Services\Api\AbstractCRUDService;
use Illuminate\Database\Eloquent\Model;

final class RegionsFederalDistrictRelationsService
{
    protected RegionsFederalDistrictRelationsRepository $regionsFederalDistrictRelationsRepository;

    /**
     * @param RegionsFederalDistrictRelationsRepository $regionsFederalDistrictRelationsRepository
     */
    public function __construct(RegionsFederalDistrictRelationsRepository $regionsFederalDistrictRelationsRepository)
    {
        $this->regionsFederalDistrictRelationsRepository = $regionsFederalDistrictRelationsRepository;
    }

    /**
     * @param int $id
     * @return Model|FederalDistrict
     */
    public function indexRelations(int $id): Model|FederalDistrict
    {
        return $this->regionsFederalDistrictRelationsRepository->indexRelationships($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateRelations(array $data, int $id): void
    {
        data_set($data, 'region_id', $id);

        $this->regionsFederalDistrictRelationsRepository->updateToOneRelationship($data);
    }

    public function destroyRelations(int $id): void
    {

    }
}
