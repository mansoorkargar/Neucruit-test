<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Classes\Contracts\Services\ParticipantsService;
use Illuminate\Http\Request;

class ParticipantsController
{
    /**
     * @param ParticipantsService $participantsService
     * @return array
     */
    public function list(ParticipantsService $participantsService): array
    {
        return $participantsService->list();
    }

    /**
     * @param ParticipantsService $participantsService
     * @return array
     */
    public function statusList(ParticipantsService $participantsService): array
    {
        return $participantsService->statusList();
    }


    /**
     * @param ParticipantsService $participantsService
     * @return array
     */
    public function genderList(ParticipantsService $participantsService): array
    {
        return $participantsService->genderList();
    }

    /**
     * @param ParticipantsService $participantsService
     * @param Request $request
     * @return array
     */
    public function filteredList(ParticipantsService $participantsService, Request $request): array
    {
        return $participantsService->filteredList($request->filters, $request->study['id']);
    }

    /**
     * @param ParticipantsService $participantsService
     * @param Request $request
     * @return array
     */
    public function filteredAllList(ParticipantsService $participantsService, Request $request): array
    {
        return $participantsService->filteredAllList($request->filters, $request->study['id']);
    }

    /**
     * @param ParticipantsService $participantsService
     * @return array
     */
    public function filterFields(ParticipantsService $participantsService): array
    {
        return $participantsService->filterFields();
    }

    /**
     * @param $participant_id
     * @param ParticipantsService $participantsService
     * @return array
     */
    public function showParticipantEmails($participantId, ParticipantsService $participantsService): array
    {
        return $participantsService->getParticipantEmails($participantId);
    }

    /**
     * @param $participant_id
     * @param ParticipantsService $participantsService
     * @return array
     */
    public function show($participantId, ParticipantsService $participantsService): array
    {
        return $participantsService->show($participantId);
    }
}
