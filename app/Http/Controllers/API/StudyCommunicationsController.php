<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Study;
use Illuminate\Http\Request;
use App\Models\Communication;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CommunicationRequest;
use App\Classes\Contracts\Services\StudyCommunicationService;

class StudyCommunicationsController extends APIController
{
    /**
     * Retrieve a list of communication templates
     * 
     * @param Study                     $study   Study
     * @param Request                   $request Request
     * @param StudyCommunicationService $service Study service
     * 
     * @return JsonResponse
     */
    public function index(
        Study $study,
        Request $request,
        StudyCommunicationService $service
    ): JsonResponse {
        return $this->response($service->getCommunicationsByStudy($study)->get());
    }

    /**
     * Retrieve a communication template
     * 
     * @param Study                      $study         Study
     * @param Communication             $communication Communication
     * @param Request                   $request       Request
     * @param StudyCommunicationService $service       Study service
     * 
     * @return JsonResponse
     */
    public function show(
        Study $study,
        Communication $communication,
        Request $request,
        StudyCommunicationService $service
    ): JsonResponse {
        return $this->response(
            $service->show($study, $communication)
        );
    }

    /**
     * Update a communication template
     * 
     * @param Study                     $study         Study
     * @param Communication             $communication Communication
     * @param CommunicationRequest      $request       Request
     * @param StudyCommunicationService $service       Study service
     * 
     * @return JsonResponse
     */
    public function update(
        Study $study,
        Communication $communication,
        CommunicationRequest $request,
        StudyCommunicationService $service
    ): JsonResponse {
        return $this->response(
            $service->update(
                $study,
                $communication,
                $request
            )
        );
    }

    /**
     * Update a column
     * 
     * @param Study                     $study         Study
     * @param Communication             $communication Communication
     * @param CommunicationRequest      $request       Request
     * @param StudyCommunicationService $service       Study service
     * 
     * @return JsonResponse
     */
    public function updateColumn(
        Study $study,
        Communication $communication,
        Request $request,
        StudyCommunicationService $service
    ): JsonResponse {
        return $this->response(
            $service->updateColumn(
                $study,
                $communication,
                $request
            )
        );
    }
}
