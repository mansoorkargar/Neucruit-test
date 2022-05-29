<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Invitation;
use App\Models\Participant;
use App\Models\User;
use App\Models\Study;
use App\Jobs\InviteUserMailJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Classes\Contracts\Services\StudyService as StudyServiceContract;
use App\Enums\StudyQuestionTypeEnum;

class StudyService implements StudyServiceContract
{
    /**
     * Get study users
     *
     * @param User    $user   User
     * @param ?string $search Search string
     *
     * @return array
     */
    public function list(
        User $user,
        ?string $search = null
    ): BelongsToMany {
        $studies = $user->studies();
        if ($search) {
            $studies = $studies->where('name',  'like', '%' . $search . '%');
        }

        return $studies;
    }

    /**
     * @param Study $study
     * @return Builder[]|Collection
     */
    public function invitedList(Study $study)
    {
        return Invitation::query()->where('study_id', $study->id)->get();
    }

    /**
     * Get users by study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return array
     */
    public function getUsersByStudy(
        Study $study,
        ?string $search = null
    ): BelongsToMany {
        $users = $study->users();
        if ($search) {
            $users = $users->where('name',  'like', '%' . $search . '%');
        }

        return $users;
    }

    /**
     * Get users by study
     *
     * @param Study   $study  Study
     * @param ?string $search Search string
     *
     * @return array
     */
    public function getParticipantsByStudy(
        Study $study,
        ?string $search = null
    ): HasMany {
        $participants = $study->participants();
        return $participants->whereHas('status', function ($query) {
            $query->where('name', 'NOT_REACHABLE');
        })->with('gender');
    }

    public function participantsCountries(Study $study): array
    {
        $participants = $study->participants();
        $countries = $participants->pluck('country')->toArray();
        $unique = array_unique($countries);
        $count = [];

        foreach ($countries as $country) {
            if ($country) {
                $count[] = $country;
            } else {
                $country[] = 'No country';
            }
        }

        $count = array_count_values($count);
        $percentage = [];

        foreach ($count as $val){
            $percentage[] = number_format($val / array_sum($count) * 100, 2);
        }

        return ['unique' => $unique, 'count' => $count, 'percentage' => $percentage];
    }

    /**
     * Get users by study
     *
     * @param Study $study Study
     * @param ?string $search Search string
     *
     * @return HasMany
     */
    public function allParticipantList(
        Study $study,
        ?string $search = null
    ): HasMany {
        $participants = $study->participants()->with('gender');
        return $participants;
    }

    /**
     * Get users by study
     *
     * @param Study $study Study
     * @param ?string $search Search string
     *
     * @return HasMany
     */
    public function getParticipantsByStudyWithStatus(
        Study $study,
        ?string $search = null
    ): HasMany
    {
        $participants = $study->participants();
        return $participants->whereHas('status', function ($query) {
            $query->where('name', 'CONFIRMED');
        })->with('gender');
    }

    /**
     * @param Study $study
     * @param $participant
     * @param $status
     * @return void
     */
    public function changeParticipantStatus(Study $study, Participant $participant, int $statusId): void
    {
        $participant = $study->participants()->findOrFail($participant->id);
        $participant->status_id = $statusId;
        $participant->save();
    }

    /**
     * Get study
     *
     * @param Study $study Study
     *
     * @return Study
     */
    public function show(Study $study): Study
    {
        return $study;
    }

    /**
     * @param $study
     * @param $invited_user_id
     * @return array
     */
    public function storeParticipant(Study $study, $request): Participant
    {
        $data      = [];
        $questions = $study->study_questions()->get();

        foreach ($questions as $question) {
            if ($question->type == StudyQuestionTypeEnum::EMAIL) {
                $data['email'] = $request->get((string) $question->id);
            } elseif ($question->type == StudyQuestionTypeEnum::ADDRESS) {
                $data['country'] = $request->get((string) $question->id);
            } elseif ($question->type == StudyQuestionTypeEnum::GENDER) {
                $data['gender_id'] = $request->get((string) $question->id);
            } elseif ($question->type == StudyQuestionTypeEnum::GENDER) {
                $data['ethnicity'] = $request->get((string) $question->id);
            } elseif ($question->type == StudyQuestionTypeEnum::BIRTHDATE) {
                try {
                    $data['birthdate'] = Carbon::parse($request->get((string) $question->id))->format('Y-m-d');
                    $data['age']       = Carbon::parse($request->get((string) $question->id))->diffInYears(now());
                } catch (\Exception $e) {
                }
            }
        }

        $data['json'] = [
            'questions' => $questions->toArray(),
            'asnwers'   => $request->all(),
        ];

        return $study->participants()->create($data);
    }
}
