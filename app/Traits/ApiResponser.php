<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    /**
     * Build a successful response
     *
     * @param    $data
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * Build an error response
     *
     * @param  array|string  $message
     * @param  int  $code
     * @return JsonResponse
     */
    protected function errorResponse(array|string $message, int $code): JsonResponse
    {
        return response()->json($message, $code);
    }
}
