<?php

namespace App\Http\Controllers\API\Admin\Company;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Admin\Company\StoreCompanyRequest;
use App\Http\Requests\Admin\Company\UpdateCompanyRequest;
use App\Http\Resources\Admin\Company\CompanyResource;
use App\Services\Admin\Company\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends ApiController
{
    private CompanyService $companyService;

    public function __construct(CompanyService $service)
    {
        $this->companyService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.company.list'),
            Response::HTTP_FORBIDDEN
        );

        $query = request()->query('query');

        if ($query) {
            return $this->successResponse($this->companyService->search($query));
        }

        return $this->successResponse($this->companyService->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCompanyRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.company.create'),
            Response::HTTP_FORBIDDEN
        );

        $company = $this->companyService->create($request);

        return $this->successResponse($company, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $company
     * @return JsonResponse
     */
    public function show(int $company): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.company.show'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(new CompanyResource($this->companyService->show($company)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCompanyRequest  $request
     * @param  int  $company
     * @return JsonResponse
     */
    public function update(UpdateCompanyRequest $request, int $company): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.company.update'),
            Response::HTTP_FORBIDDEN
        );

        $company = $this->companyService->update($request, $company);

        return $this->successResponse($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $company
     * @return JsonResponse
     */
    public function destroy(int $company): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.company.delete'),
            Response::HTTP_FORBIDDEN
        );

        $company = $this->companyService->destroy($company);

        return $this->successResponse($company);
    }
}
