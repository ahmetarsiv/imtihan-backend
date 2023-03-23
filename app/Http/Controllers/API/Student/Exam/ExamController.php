<?php

namespace App\Http\Controllers\API\Student\Exam;

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Exam\StoreExamRequest;
use App\Http\Resources\User\Exam\ExamResource;
use App\Models\Exam;
use App\Services\User\Exam\ExamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExamController extends ApiController
{

    public function __construct(ExamService $service)
    {
        $this->examService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.exam.list'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(ExamResource::collection($this->examService->list([], ['user_id' => auth()->id()])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExamRequest $request
     * @return JsonResponse
     */
    public function store(StoreExamRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.exam.create'),
            Response::HTTP_FORBIDDEN
        );

        $request->merge(['user_id' => auth()->id()]);
        $exam = $this->examService->create($request);

        return $this->successResponse($exam,Response::HTTP_CREATED);
    }

    /*
     * Store a user answer to exam
     */
    public function storeAnswer(Request $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.exam.create.answer'),
            Response::HTTP_FORBIDDEN
        );

        $answer = $this->examService->storeUserAnswer($request);

        return $this->successResponse($answer, Response::HTTP_CREATED);
    }
}
