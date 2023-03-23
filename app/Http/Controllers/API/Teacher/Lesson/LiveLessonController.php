<?php

namespace App\Http\Controllers\API\Teacher\Lesson;

use App\Helper\Helper;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Teacher\Lesson\StoreLiveLessonRequest;
use App\Http\Requests\Teacher\Lesson\UpdateLiveLessonRequest;
use App\Http\Resources\Teacher\Lesson\LiveLessonResource;
use App\Services\Teacher\Lesson\LiveLessonService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LiveLessonController extends ApiController
{
    private LiveLessonService $liveLessonService;

    public function __construct(LiveLessonService $service)
    {
        $this->liveLessonService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('teacher.live-lesson.list'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(LiveLessonResource::collection($this->liveLessonService->list([], ['company_id' => Helper::userInfo()->company_id])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLiveLessonRequest  $request
     * @return JsonResponse
     */
    public function store(StoreLiveLessonRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('teacher.live-lesson.create'),
            Response::HTTP_FORBIDDEN
        );

        $request->merge(['company_id' => Helper::userInfo()->company_id]);

        $live_lesson = $this->liveLessonService->create($request);

        return $this->successResponse($live_lesson,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $live_lesson
     * @return JsonResponse
     */
    public function show(int $live_lesson): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('teacher.live-lesson.show'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(new LiveLessonResource($this->liveLessonService->show($live_lesson)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLiveLessonRequest  $request
     * @param  int  $live_lesson
     * @return JsonResponse
     */
    public function update(UpdateLiveLessonRequest $request, int $live_lesson): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('teacher.live-lesson.update'),
            Response::HTTP_FORBIDDEN
        );

        $live_lesson = $this->liveLessonService->update($request, $live_lesson);

        return $this->successResponse($live_lesson);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $live_lesson
     * @return JsonResponse
     */
    public function destroy(int $live_lesson): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('teacher.live-lesson.delete'),
            Response::HTTP_FORBIDDEN
        );

        $live_lesson = $this->liveLessonService->destroy($live_lesson);

        return $this->successResponse($live_lesson);
    }
}
