<?php

namespace App\Http\Controllers\API\Student\Booking;

use App\Helper\Helper;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Booking\StoreBookingRequest;
use App\Http\Resources\User\Booking\BookingResource;
use App\Services\User\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends ApiController
{
    private BookingService $bookingService;

    public function __construct(BookingService $service)
    {
        $this->bookingService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.booking.list'),
            Response::HTTP_FORBIDDEN
        );

        return $this->successResponse(BookingResource::collection($this->bookingService->list([], ['company_id' => Helper::userInfo()->company_id, 'user_id' => auth()->id()])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBookingRequest  $request
     * @return JsonResponse
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.booking.create'),
            Response::HTTP_FORBIDDEN
        );

        $request->merge(['company_id' => Helper::userInfo()->company_id, 'user_id' => auth()->id()]);

        $booking = $this->bookingService->create($request);

        return $this->successResponse($booking, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $booking
     * @return JsonResponse
     */
    public function destroy(int $booking): JsonResponse
    {
        abort_unless(auth()->user()->tokenCan('student.booking.delete'),
            Response::HTTP_FORBIDDEN
        );

        $this->authorize('delete', $this->bookingService->show($booking));

        $booking = $this->bookingService->destroy($booking);

        return $this->successResponse($booking);
    }
}
