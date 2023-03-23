<?php

namespace App\Http\Controllers\API\Student\Support;

use App\Helper\Helper;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Support\StoreSupportRequest;
use App\Http\Resources\User\Support\SupportResource;
use App\Services\User\Support\SupportService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SupportController extends ApiController
{
    private SupportService $supportService;

    public function __construct(SupportService $service)
    {
        $this->supportService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.support.list'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(SupportResource::collection($this->supportService->list([], ['company_id' => Helper::userInfo()->company_id, 'user_id' => auth()->id()])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSupportRequest  $request
     * @return JsonResponse
     */
    public function store(StoreSupportRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.support.create'),
            Response::HTTP_FORBIDDEN
        );

        $request->merge(['company_id' => Helper::userInfo()->company_id, 'user_id' => auth()->id()]);

        $support = $this->supportService->create($request);

        return $this->successResponse($support,Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $support
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $support): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.support.delete'),
            Response::HTTP_FORBIDDEN
        );

        $this->authorize('delete', $this->supportService->show($support));

        $support = $this->supportService->destroy($support);

        return $this->successResponse($support);
    }
}
