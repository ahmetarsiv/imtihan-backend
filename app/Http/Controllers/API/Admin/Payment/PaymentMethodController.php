<?php

namespace App\Http\Controllers\API\Admin\Payment;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Admin\Payment\StorePaymentMethodRequest;
use App\Http\Requests\Admin\Payment\UpdatePaymentMethodRequest;
use App\Http\Resources\Admin\Payment\PaymentMethodResource;
use App\Services\Admin\Payment\PaymentMethodService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PaymentMethodController extends ApiController
{
    private PaymentMethodService $paymentMethodService;

    public function __construct(PaymentMethodService $service)
    {
        $this->paymentMethodService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.payment-method.list'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(PaymentMethodResource::collection($this->paymentMethodService->list()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePaymentMethodRequest  $request
     * @return JsonResponse
     */
    public function store(StorePaymentMethodRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.payment-method.create'),
            Response::HTTP_FORBIDDEN
        );

        $payment_method = $this->paymentMethodService->create($request);

        return $this->successResponse($payment_method, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $payment_method
     * @return JsonResponse
     */
    public function show(int $payment_method): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.payment-method.show'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(new PaymentMethodResource($this->paymentMethodService->show($payment_method)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePaymentMethodRequest  $request
     * @param  int  $payment_method
     * @return JsonResponse
     */
    public function update(UpdatePaymentMethodRequest $request, int $payment_method): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.payment-method.update'),
            Response::HTTP_FORBIDDEN
        );

        $payment_method = $this->paymentMethodService->update($request, $payment_method);

        return $this->successResponse($payment_method);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $payment_method
     * @return JsonResponse
     */
    public function destroy(int $payment_method): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('admin.payment-method.delete'),
            Response::HTTP_FORBIDDEN
        );

        $payment_method = $this->paymentMethodService->destroy($payment_method);

        return $this->successResponse($payment_method);
    }
}
