<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Pipelines\FederalDistricts\FederalDistrictPipeline;
use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;
use App\Services\Api\AbstractCRUDService;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class FederalDistrictService extends AbstractCRUDService
{
    protected FederalDistrictRepository $federalDistrictRepository;
    protected FederalDistrictPipeline $federalDistrictPipeline;

    /**
     * @param FederalDistrictRepository $federalDistrictRepository
     * @param FederalDistrictPipeline $federalDistrictPipeline
     */
    public function __construct(
        FederalDistrictRepository $federalDistrictRepository, FederalDistrictPipeline $federalDistrictPipeline)
    {
        $this->federalDistrictRepository = $federalDistrictRepository;
        $this->federalDistrictPipeline = $federalDistrictPipeline;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->federalDistrictRepository->index();
    }

    /**
     * @param array $data
     * @return Model|FederalDistrict
     * @throws \Throwable
     */
    public function store(array $data): Model|FederalDistrict
    {
        return $this->federalDistrictPipeline->store($data);
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        return $this->federalDistrictRepository->show($id);
    }

    /**
     * @param array $data
     * @return void
     * @throws \Throwable
     */
    public function update(array $data): void
    {
        $this->federalDistrictPipeline->update($data);
    }

    /**
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    public function destroy(int $id): void
    {
        $this->federalDistrictPipeline->destroy($id);
    }
}
