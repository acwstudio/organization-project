<?php

namespace App\Http\Controllers\Api\Faculties;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Faculties\FacultyCollection;
use App\Http\Resources\Api\Faculties\FacultyResource;
use App\Models\Faculty;
use App\Repositories\Api\FacultyRepository;
use App\Services\Api\FacultyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacultyController extends Controller
{
    private FacultyService $facultyService;

    /**
     * @param FacultyService $facultyService
     */
    public function __construct(FacultyService $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $faculties = $this->facultyService->index()->paginate($perPage);

        return (new FacultyCollection($faculties))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $faculty = $this->facultyService->show($id)->first();

        return (new FacultyResource($faculty))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
