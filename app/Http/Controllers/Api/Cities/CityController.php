<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cities\CityIndexRequest;
use App\Http\Requests\Api\V1\Cities\CityStoreRequest;
use App\Http\Requests\Api\V1\Cities\CityUpdateRequest;
use App\Http\Resources\Api\Cities\CityCollection;
use App\Http\Resources\Api\Cities\CityResource;
use App\Services\Api\Cities\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @var CityService
     */
    private CityService $cityService;

    /**
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(CityIndexRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $cities = $this->cityService->index()->simplePaginate($perPage)->appends($request->query());

        return (new CityCollection($cities))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityStoreRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(CityStoreRequest $request): JsonResponse
    {
        $data = $request->all();

        $city = $this->cityService->store($data);

        return (new CityResource($city))
            ->response()
            ->header('Location', route('cities.show', [
                'id' => $city->id
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $city = $this->cityService->show($id)->first();

        return (new CityResource($city))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(CityUpdateRequest $request, $id)
    {
        $data = $request->all();
        data_set($data, 'id', $id);

        $this->cityService->update($data);

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->cityService->destroy($id);

        return response()->json(null, 204);
    }
}
