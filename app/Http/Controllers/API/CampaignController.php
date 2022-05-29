<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Repositories\CampaignRepository;
use App\Http\Requests\CampaignRequest;
use Illuminate\Http\JsonResponse;

class CampaignController extends APIController
{
    protected $repository;

    public function __construct(CampaignRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->response([
            'data' => $this->repository->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CampaignRequest $request
     * @return JsonResponse
     */
    public function store(CampaignRequest $request): JsonResponse
    {
        return $this->response([
            'data' => $this->repository->create($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->response([
            'data' => $this->repository->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CampaignRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(CampaignRequest $request, $id): JsonResponse
    {
        return $this->response([
            'data' => $this->repository->update($request, $id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->response([], $this->repository->delete($id) ? 204 : 304);
    }
}
