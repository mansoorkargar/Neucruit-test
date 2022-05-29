<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;

/**
 * ProfileController class
 */
class ProfileController extends APIController
{
    /**
     * Get logged in user for teting purposes.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->response(['user' => auth()->user()]);
    }
}
