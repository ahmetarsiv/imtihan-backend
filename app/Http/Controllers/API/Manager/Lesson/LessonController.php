<?php

namespace App\Http\Controllers\API\Manager\Lesson;

use App\Helper\Helper;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Manager\Lesson\StoreLessonRequest;
use App\Http\Requests\Manager\Lesson\UpdateLessonRequest;
use App\Http\Resources\Manager\Lesson\LessonResource;
use App\Services\Manager\Lesson\LessonService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonController extends ApiController
{
    private LessonService $lessonService;

    public function __construct(LessonService $service)
    {
        $this->lessonService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('manager.lesson.list'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(LessonResource::collection($this->lessonService->list([], ['company_id' => Helper::userInfo()->company_id])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLessonRequest  $request
     * @return JsonResponse
     */
    public function store(StoreLessonRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('manager.lesson.create'),
            Response::HTTP_FORBIDDEN
        );

        $request->merge(['company_id' => Helper::userInfo()->company_id]);

        $lesson = $this->lessonService->create($request);

        return $this->successResponse($lesson,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $lesson
     * @return JsonResponse
     */
    public function show(int $lesson): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('manager.lesson.show'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(new LessonResource($this->lessonService->show($lesson, ['lesson'], ['company_id' => Helper::userInfo()->company_id])));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLessonRequest  $request
     * @param  int  $lesson
     * @return JsonResponse
     */
    public function update(UpdateLessonRequest $request, int $lesson): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('manager.lesson.update'),
            Response::HTTP_FORBIDDEN
        );

        $this->authorize('update', $this->lessonService->show($lesson));

        $lesson = $this->lessonService->update($request, $lesson);

        return $this->successResponse($lesson);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $lesson
     * @return JsonResponse
     */
    public function destroy(int $lesson): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('manager.lesson.delete'),
            Response::HTTP_FORBIDDEN
        );

        $this->authorize('delete', $this->lessonService->show($lesson));

        $lesson = $this->lessonService->destroy($lesson);

        return $this->successResponse($lesson);
    }
}
