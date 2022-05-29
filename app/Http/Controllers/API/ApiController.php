<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * APIController Class
 *
 * Formatting all api controller responses
 */
class APIController extends Controller
{
    /**
     * Take array result and returns JSON response.
     *
     * @param mixed $result Response body
     * @param int   $status Status code
     *
     * @return JsonResponse
     */
    public function response(
        mixed $result = null,
        int $status = 200
    ): JsonResponse {
        return response()->json($result, $status);
    }
}
