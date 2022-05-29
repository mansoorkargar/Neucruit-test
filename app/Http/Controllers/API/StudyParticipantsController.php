<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\Study;
use App\Enums\RoleEnum;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Classes\Contracts\Services\StudyService;

class StudyParticipantsController extends APIController
{
    /**
     * @param Study $study Study
     * @param Request $request Request
     * @param StudyService $studyService Study service
     *
     * @return JsonResponse
     */
    public function list(Study $study, Request $request, StudyService $studyService): JsonResponse {
        return $this->response(
            $studyService->getParticipantsByStudy($study, $request->search)->with(['status'])->simplePaginate(1000)
        );
    }

    /**
     * @param Study $study Study
     * @param Request $request Request
     * @param StudyService $studyService Study service
     *
     * @return JsonResponse
     */
    public function allParticipantList(Study $study, Request $request, StudyService $studyService): JsonResponse {
        return $this->response(
            $studyService->allParticipantList($study, $request->search)->with(['status'])->simplePaginate(1000)
        );
    }

    /**
     * @param Study $study Study
     * @param Request $request Request
     * @param StudyService $studyService Study service
     *
     * @return JsonResponse
     */
    public function listWithStatus(Study $study, Request $request, StudyService $studyService): JsonResponse {;
        return $this->response(
            $studyService->getParticipantsByStudyWithStatus($study, $request->search)->with(['status'])->simplePaginate(1000)
        );
    }

    /**
     * @param Study $study Study
     * @param StudyService $studyService Study service
     *
     * @return JsonResponse
     */
    public function participantsCountries(
        Study $study,
        StudyService $studyService
    ): JsonResponse {
        return $this->response(
            $studyService->participantsCountries($study)
        );
    }

    /**
     * @param $study
     * @param $participantId
     * @param Request $request
     * @param StudyService $studyService
     * @return JsonResponse
     */
    public function changeParticipantStatus(
        Study $study,
        Participant $participant,
        Request $request,
        StudyService $studyService
    ): JsonResponse {
        return $this->response(
            $studyService->changeParticipantStatus($study, $participant, $request->statusId)
        );
    }

    /**
     * @param $study
     * @param $participantId
     * @param Request $request
     * @param StudyService $studyService
     * @return JsonResponse
     */
    public function export($study, Request $request)
    {
        if (auth()->user()->role_id != RoleEnum::CLINICAL_STAFF) {
            abort(404);
        }
        
        $items = $study->participants()->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject);

        $csv->insertOne(array_keys($items[0]->getAttributes()));

        foreach ($items as $item) {
            if ($item->json){

                $item['json'] =  json_encode($item->json);
            }
            $csv->insertOne($item->toArray());
        }

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="participants.csv"',
        ]);
    }

    /**
     * @param $study
     * @param $participantId
     * @param Request $request
     * @param StudyService $studyService
     * @return JsonResponse
     */
    public function store(
        Study $study,
        Request $request,
        StudyService $studyService
    ) {
        return $this->response(
            $studyService->storeParticipant($study, $request)
        );
    }
}
