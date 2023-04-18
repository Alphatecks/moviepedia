<?php

declare (strict_types = 1);

namespace App\Custom;

trait ApiResponseTrait
{
    public function success($message, $data = [], $status = 200)
    {
        return response()->json([
            "code" => 1,
            'message' => $message,
            'data' => $data ?? null,
        ], $status);
    }

    public function error($message, $status = 500)
    {
        return response()->json([
            "code" => 3,
            'error' => $message,
        ], $status);
    }
}
