<?php

declare(strict_types=1);

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse {

    public function succesResponse($data, int $code = Response::HTTP_OK): JsonResponse
    {
        return \response() -> json(['data' => $data], $code);
    }

    public function errorResponse($data, int $code = Response::HTTP_BAD_GATEWAY): JsonResponse
    {
        return \response() -> json(['error' => $data], $code);
    }
}
