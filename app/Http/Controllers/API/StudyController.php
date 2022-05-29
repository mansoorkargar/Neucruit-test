<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\StudyResource;
use App\Http\Requests\Study\InviteUserRequest;
use App\Classes\Contracts\Services\StudyService;

class StudyController extends APIController
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function list(Request $request, StudyService $studyService): JsonResponse
    {
        return $this->response(
            StudyResource::collection(
                $studyService->list($request->user(), $request->search)->simplePaginate(50)
            )
        );
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function show(
        Study $study,
        StudyService $studyService
    ): JsonResponse {
        return $this->response(
            new StudyResource($studyService->show($study))
        );
    }
}
