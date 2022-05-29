<?php


namespace App\Classes\Contracts\Services;

interface ParticipantsService
{
    /**
     * @return array
     */
    public function list(): array;

    /**
     * @return array
     */
    public function statusList(): array;


    /**
     * @return array
     */
    public function genderList(): array;

    /**
     * @param array $filters
     * @param $studyId
     * @return array
     */
    public function filteredList(array $filters, $studyId): array;

    /**
     * @param array $filters
     * @param $studyId
     * @return array
     */
    public function filteredAllList(array $filters, $studyId): array;

    /**
     * @return mixed
     */
    public function filterFields(): array;

    /**
     * @param $participant_id
     * @return array
     */
    public function getParticipantEmails($participant_id): array;

    /**
     * @param $participant_id
     * @return array
     */
    public function show($participant_id): array;
}
