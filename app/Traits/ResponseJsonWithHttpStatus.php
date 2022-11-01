<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Throwable;

Trait ResponseJsonWithHttpStatus
{
    /**
     * Return response Json with success
     *
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public function success(array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data,
        ], $status);
    }


    /**
     * Return response Json with error
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function error(string $message, int $status = 422): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => [],
        ], $status);
    }

}
