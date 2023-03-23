<?php

namespace App\Http\Controllers\API\Admin\ClassRoom;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Admin\ClassRoom\StoreClassRoomRequest;
use App\Http\Requests\Admin\ClassRoom\UpdateClassRoomRequest;
use App\Http\Resources\Admin\ClassRoom\ClassRoomResource;
use App\Services\Admin\ClassRoom\ClassRoomService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ClassRoomController extends ApiController
{
    private ClassRoomService $classRoomService;

    public function __construct(ClassRoomService $service)
    {
        $this->classRoomService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(ClassRoomResource::collection($this->classRoomService->list()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreClassRoomRequest  $request
     * @return JsonResponse
     */
    public function store(StoreClassRoomRequest $request): JsonResponse
    {
        $class_room = $this->classRoomService->create($request);

        return $this->successResponse($class_room, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $class_room
     * @return JsonResponse
     */
    public function show(int $class_room): JsonResponse
    {
        return $this->successResponse(new ClassRoomResource($this->classRoomService->show($class_room)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateClassRoomRequest  $request
     * @param  int  $class_room
     * @return JsonResponse
     */
    public function update(UpdateClassRoomRequest $request, int $class_room): JsonResponse
    {
        $class_room = $this->classRoomService->update($request, $class_room);

        return $this->successResponse($class_room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $class_room
     * @return JsonResponse
     */
    public function destroy(int $class_room): JsonResponse
    {
        $class_room = $this->classRoomService->destroy($class_room);

        return $this->successResponse($class_room);
    }
}
