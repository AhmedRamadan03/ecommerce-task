<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Return success response
     */
    protected function successResponse($data = [], string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return error response
     */
    protected function errorResponse(string $message = 'Error', $errors = [], int $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
