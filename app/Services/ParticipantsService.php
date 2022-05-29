<?php

namespace App\Services;

use Exception;
use App\Models\Gender;
use App\Enums\RoleEnum;
use App\Models\Statuses;
use App\Models\Participant;
use App\Models\ParticipantEmails;
use App\Classes\Contracts\Services\ParticipantsService as ParticipantsServiceContract;

class ParticipantsService implements ParticipantsServiceContract
{
    /**
     * @return array
     */
    public function list(): array
    {
        try {
            return [
                'success' => true,
                'data' => Participant::query()
                                     ->whereIn('study_id', auth()->user()->studies()->pluck('studies.id')->toArray())
                                     ->with(['gender', 'status'])
                                     ->get()
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception
            ];
        }
    }

    /**
     * @return array
     */
    public function filterFields(): array
    {
        try {
            $ages        = Participant::query()
                                      ->whereIn('study_id', auth()->user()->studies()->pluck('studies.id')->toArray())
                                      ->distinct()
                                      ->get(['age']);
            $ethnicities = Participant::query()
                                       ->whereIn('study_id', auth()->user()->studies()->pluck('studies.id')->toArray())
                                       ->distinct()
                                       ->get(['ethnicity']);

            return [
                'success' => true,
                'data' => [
                    'ages' => $ages,
                    'ethnicities' => $ethnicities,
                ]
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception
            ];
        }
    }

    /**
     * @return array
     */
    public function statusList(): array
    {
        try {
            return [
                'success' => true,
                'data' => Statuses::query()->get()
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception
            ];
        }
    }


    /**
     * @return array
     */
    public function genderList(): array
    {
        try {
            return [
                'success' => true,
                'data'    => Gender::query()->get()
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception
            ];
        }
    }

    /**
     * @param array $filters
     * @param $studyId
     * @return array
     */
    public function filteredList(array $filters, $studyId): array
    {
        $filteredWithoutStatus = Participant::query()
        ->whereHas('status', function ($query) {
            $query->where('name', 'NOT_REACHABLE');
        })
        ->where('study_id', $studyId)
        ->whereIn('study_id', auth()->user()->studies()->pluck('studies.id')->toArray())
        ->when($filters['status'], function ($status) use($filters) {
            $status->whereHas('status', function ($statusRel) use($filters) {
                $statusRel->where('status_id', $filters['status']);
            });
        })
        ->when($filters['age'], function ($age) use($filters) {
            $age->where('age', $filters['age']);
        })
        ->when($filters['gender'], function ($gender) use($filters) {
            $gender->whereHas('gender', function ($genderRel) use($filters) {
                $genderRel->where('gender_id', $filters['gender']);
            });
        })
        ->when($filters['ethnicity'], function ($ethnicity) use($filters) {
            $ethnicity->where('ethnicity', $filters['ethnicity']);
        })
        ->with(['gender', 'status'])
        ->get();

        $filteredWitStatus = Participant::query()->whereHas('status', function ($query) {
            $query->where('name', 'CONFIRMED');
        })
        ->where('study_id', $studyId)
        ->whereIn('study_id', auth()->user()->studies()->pluck('studies.id')->toArray())
        ->when($filters['age'], function ($age) use ($filters) {
            $age->where('age', $filters['age']);
        })
        ->when($filters['gender'], function ($gender) use ($filters) {
            $gender->whereHas('gender', function ($genderRel) use ($filters) {
                $genderRel->where('gender_id', $filters['gender']);
            });
        })
        ->when($filters['ethnicity'], function ($ethnicity) use ($filters) {
            $ethnicity->where('ethnicity', $filters['ethnicity']);
        })
        ->with(['gender', 'status'])
        ->get();

        try {
            if ($filters['status'] == 5) {
                return [
                    'success' => true,
                    'data' => ['withoutStatus' => $filteredWithoutStatus, 'withStatus' => []]
                ];
            } elseif ($filters['status'] == 3) {
                return [
                    'success' => true,
                    'data' => ['withStatus' => $filteredWitStatus, 'withoutStatus' => []]
                ];
            } else {
                return [
                    'success' => true,
                    'data' => ['withStatus' => $filteredWitStatus, 'withoutStatus' => $filteredWithoutStatus]
                ];
            }

        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception
            ];
        }
    }

    /**
     * Undocumented function
     *
     * @param array $filters
     * @param [type] $studyId
     * @return array
     */
    public function filteredAllList(array $filters, $studyId): array
    {
        $filtered = Participant::query()
        ->where('study_id', $studyId)
        ->whereIn('study_id', auth()->user()->studies()->pluck('studies.id')->toArray())                  
        ->when($filters['status'], function ($status) use($filters) {
            $status->whereHas('status', function ($statusRel) use($filters) {
                $statusRel->where('status_id', $filters['status']);
            });
        })
        ->when($filters['age'], function ($age) use($filters) {
            $age->where('age', $filters['age']);
        })
        ->when($filters['gender'], function ($gender) use($filters) {
            $gender->whereHas('gender', function ($genderRel) use($filters) {
                $genderRel->where('gender_id', $filters['gender']);
            });
        })
        ->when($filters['ethnicity'], function ($ethnicity) use($filters) {
            $ethnicity->where('ethnicity', $filters['ethnicity']);
        })
        ->with(['gender', 'status'])
        ->get();

        try {
            return [
                'success' => true,
                'data' => $filtered
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception
            ];
        }
    }

    /**
     * @param $participant_id
     * @return array
     */
    public function getParticipantEmails($participant_id): array
    {
        return [
            'success' => true,
            'data'    => ParticipantEmails::query()->where('participant_id', $participant_id)
                                                   ->whereHas('study.users', function($q) { $q->where('users.id', auth()->user()->id); })
                                                   ->with(['study', 'participant', 'emailTypes'])
                                                   ->get()
        ];
    }

    /**
     * @param $participantId
     * @return array
     */
    public function show($participantId): array
    {
        return [
            'success' => true,
            'data'    => auth()->user()->role_id == RoleEnum::CLINICAL_STAFF
                            ? Participant::query()
                                         ->whereHas('study.users', function($q) { $q->where('users.id', auth()->user()->id); })
                                         ->where('id', $participantId)
                                         ->firstOrFail()
                            : [],
        ];
    }
}
