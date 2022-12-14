<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ApiEntityIdentifierResource;
use App\Services\Api\Organizations\OrganizationsCityRelationsService;
use Illuminate\Http\JsonResponse;

class OrganizationsCityRelationshipsController extends Controller
{
    protected OrganizationsCityRelationsService $organizationsCityRelationsService;

    /**
     * @param OrganizationsCityRelationsService $organizationsCityRelationsService
     */
    public function __construct(OrganizationsCityRelationsService $organizationsCityRelationsService)
    {
        $this->organizationsCityRelationsService = $organizationsCityRelationsService;
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        data_set($data, 'relation_method', 'city');
        data_set($data, 'id', $id);

        $model = $this->organizationsCityRelationsService->indexRelations($data)->first();

        return $model ? (new ApiEntityIdentifierResource($model))->response() : response()->json(null, 204);
    }
}
