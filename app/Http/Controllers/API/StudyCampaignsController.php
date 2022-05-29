<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CampaignResource;
use App\Classes\Contracts\Services\StudyCampaignService;

class StudyCampaignsController extends APIController
{
    /**
     * Retrieve a list of campaigns
     * 
     * @param Study                $study   Study
     * @param Request              $request Request
     * @param StudyCampaignService $service Study invitation service
     * 
     * @return JsonResponse
     */
    public function index(
        Study $study,
        Request $request,
        StudyCampaignService $service
    ): JsonResponse {
        return $this->response(
            CampaignResource::collection($service->getCampaignsByStudy($study)->get())
        );
    }
}
