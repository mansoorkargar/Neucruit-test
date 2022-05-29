<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\RoleEnum;
use App\Enums\CommunicationTriggerEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class User
 * @package App\Models
 */
class Study extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'study_question',
        'description',
        'trial_id',
        'study_type_id',
        'studies_types',
        'investigating_audience',
        'study_run_time',
        'is_offering_incentives',
        'incentive_description',
        'field',
        'location',
        'recruitment_starts_at',
        'recruitment_ends_at',
        'participant_min_age',
        'participant_max_age',
        'gender_id',
        'condition',
        'criteria',
        'approval_number',
        'consent',
        'study_status',
        'designated_contact',
        'required_participants',
        'link_suffix',
        'created_by',
        'updated_by'
    ];

    /**
     * Casts
     */
    protected $casts = [
        'recruitment_starts_at' => 'date',
        'recruitment_ends_at'   => 'date'
    ];

    /**
     * Designs
     *
     * @return HasMany
     */
    public function designs(): HasMany
    {
        return $this->hasMany(Design::class);
    }

    /**
     * Communication email templates
     *
     * @return HasMany
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    /**
     * Invitations
     *
     * @return HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Users
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(StudyUser::class);
    }

    /**
     * Admins
     *
     * @return BelongsToMany
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->where('role_id', '=', RoleEnum::CLIENT);
    }

    /**
     * Participiants
     *
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Gender
     *
     * @return BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Questions
     *
     * @return HasMany
     */
    public function study_questions(): HasMany
    {
        return $this->hasMany(StudyQuestion::class)
                    ->orderBy('position', 'ASC')
                    ->orderBy('id', 'ASC');
    }

    /**
     * Campaigns
     *
     * @return HasMany
     */
    public function campaigns(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    /**
     * Analytics
     *
     * @return HasMany
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(StudyAnalytic::class);
    }

    /**
     * Get full title
     *
     * @return void
     */
    public function getFullTitle() {
        $users = $this->admins->map(function($item) {
            return $item->name . ' ' . $item->last_name . ' - ' . $item->company;
        })->join('; ');

        return $users;
    }

    /**
     * Get count of participants joined study this week
     *
     * @return int
     */
    public function getParticipantsThisWeek(): int
    {
        return $this->participants()->whereBetween(
            'created_at',
            [now()->startOfWeek()->format('Y-m-d H:i:s'), now()->endOfWeek()->format('Y-m-d H:i:s')]
        )->count();
    }

    /**
     * Get recruitment end date
     *
     * @return string
     */
    public function getDaysLeft(): string
    {
        if ($this->recruitment_starts_at) {
            if ($this->recruitment_starts_at->timestamp > now()->timestamp) {
                return __('global.not_started');
            } else {
                if ($this->recruitment_ends_at) {
                    if ($this->recruitment_ends_at->timestamp > now()->timestamp) {
                        return abs($this->recruitment_ends_at->diffInDays(now()));
                    } else {
                        return 0;
                    }
                } else {
                    return '-';
                }
            }
        }

        return '-';
    }

    /**
     * Get conversion rate
     *
     * @return string
     */
    public function getConversionRate(): string
    {
        $participantsCompleted = $this->participants()->whereStatusId(CommunicationTriggerEnum::COMPLETION)->count();
        $participantsViewed    = $this->analytics()->whereAction('view')->count();

        return ($participantsViewed == 0 ? '0' : round($participantsCompleted / $participantsViewed, 2) * 100) . '%';
    }

    /**
     * Get demogragics by gender
     *
     * @return array
     */
    public function getDemographicsByGender(): array
    {
        $data = $this->participants()
                     ->selectRaw('COUNT(id) AS count, gender_id, status_id')
                     ->groupBy('gender_id')
                     ->groupBy('status_id')
                     ->get();

        $result = [];
        foreach ([1, 2, 3, 4, 5] as $statusId) {
            $result['status-' . $statusId] = $data->where('status_id', '=', $statusId)->pluck('count', 'gender_id');
        }

        return $result;
    }

    /**
     * Get demogragics by age
     *
     * @return array
     */
    public function getDemographicsByAge(): array
    {
        $data = $this->participants()
                     ->selectRaw('COUNT(id) AS count, timestampdiff(YEAR, birthdate, NOW()) as age, status_id')
                     ->groupByRaw('timestampdiff(YEAR, birthdate, NOW()), status_id')
                     ->get();

        $result = [
            'categories' => array_values($data->where('age', '>', 0)->unique('age')->pluck('age')->toArray()),
        ];

        foreach ([1, 2, 3, 4, 5] as $statusId) {
            $result['status-' . $statusId] = $data->where('status_id', '=', $statusId)->pluck('count', 'age');
        }

        return $result;
    }

    /**
     * Get demogragics by ethnicity
     *
     * @return array
     */
    public function getDemographicsByEthnicity(): array
    {
        $data = $this->participants()
                     ->selectRaw('COUNT(id) AS count, ethnicity, status_id')
                     ->groupBy('ethnicity')
                     ->groupBy('status_id')
                     ->get();

        $result = [
            'categories' => array_values($data->unique('ethnicity')->pluck('ethnicity')->toArray()),
        ];

        foreach ([1, 2, 3, 4, 5] as $statusId) {
            $result['status-' . $statusId] = $data->where('status_id', '=', $statusId)->pluck('count', 'ethnicity');
        }

        return $result;
    }

    /**
     * Channnel conversion - last 15 days
     *
     * @return array
     */
    public function getChannelConversionLast15Days(): array
    {
        $result = [
            'categories' => $this->campaigns()->pluck('name', 'id'),
        ];

        $data = $this->participants()
                     ->whereBetween('created_at', [
                         Carbon::parse('-15 days')->format('Y-m-d H:i:s'),
                         now()->format('Y-m-d H:i:s'),
                     ])
                     ->selectRaw('COUNT(id) AS count, channel_id, status_id')
                     ->whereNotNull('channel_id')
                     ->groupBy('channel_id')
                     ->groupBy('status_id')
                     ->get();

        foreach ([1, 2, 3, 4, 5] as $statusId) {
            $result['status-' . $statusId] = $data->where('status_id', '=', $statusId)->pluck('count', 'channel_id');
        }

        return $result;
    }

    /**
     * Channnel conversion - last month
     *
     * @return array
     */
    public function getChannelConversionLastMonth(): array
    {
        $result = [
            'categories' => $this->campaigns()->pluck('name', 'id'),
        ];

        $data = $this->participants()
                     ->whereBetween('created_at', [
                         Carbon::parse('-1 month')->format('Y-m-d H:i:s'),
                         now()->format('Y-m-d H:i:s'),
                     ])
                     ->whereNotNull('channel_id')
                     ->selectRaw('COUNT(id) AS count, channel_id, status_id')
                     ->groupBy('channel_id')
                     ->groupBy('status_id')
                     ->get();

        foreach ([1, 2, 3, 4, 5] as $statusId) {
            $result['status-' . $statusId] = $data->where('status_id', '=', $statusId)->pluck('count', 'channel_id');
        }

        return $result;
    }

    /**
     * Channnel conversion - last year
     *
     * @return array
     */
    public function getChannelConversionLastYear(): array
    {
        $result = [
            'categories' => $this->campaigns()->pluck('name', 'id'),
        ];

        $data = $this->participants()
                     ->whereBetween('created_at', [
                         Carbon::parse('-1 year')->format('Y-m-d H:i:s'),
                         now()->format('Y-m-d H:i:s'),
                     ])
                     ->whereNotNull('channel_id')
                     ->selectRaw('COUNT(id) AS count, channel_id, status_id')
                     ->groupBy('channel_id')
                     ->groupBy('status_id')
                     ->get();

        foreach ([1, 2, 3, 4, 5] as $statusId) {
            $result['status-' . $statusId] = $data->where('status_id', '=', $statusId)->pluck('count', 'channel_id');
        }

        return $result;
    }

    /**
     * Channnel conversion - last year
     *
     * @return array
     */
    public function getRealTimeProgress(): array
    {
        $result = [
            'yearly' => [
                'registered'   => [],
                'completed'    => [],
                'not_eligible' => [],
            ],
            'monthly' => [
                'registered'   => [],
                'completed'    => [],
                'not_eligible' => [],
            ],
            'weekly' => [
                'registered'   => [],
                'completed'    => [],
                'not_eligible' => [],
            ],
        ];

        $data = $this->participants()->orderBy('updated_at', 'ASC')->get();
        foreach ($data as $participant) {
            $yearly  = $participant->updated_at->format('Y');
            $monthly = $participant->updated_at->format('Y-m');
            $weekly  = $participant->updated_at->format('W');

            foreach (['yearly', 'monthly', 'weekly'] as $period) {
                foreach (['registered', 'completed', 'not_eligible'] as $status) {
                    if (!isset($result[$period][$status][$$period])) {
                        $result[$period][$status][$$period] = 0;
                    }
                }
            }

            if ($participant->status_id == CommunicationTriggerEnum::REGISTRATION) {
                $result['yearly']['registered'][$yearly]   += 1;
                $result['monthly']['registered'][$monthly] += 1;
                $result['weekly']['registered'][$weekly]   += 1;
            } elseif ($participant->status_id == CommunicationTriggerEnum::COMPLETION) {
                $result['yearly']['completed'][$yearly]   += 1;
                $result['monthly']['completed'][$monthly] += 1;
                $result['weekly']['completed'][$weekly]   += 1;
            } elseif ($participant->status_id == CommunicationTriggerEnum::IS_INELIGIBLE) {
                $result['yearly']['not_eligible'][$yearly]   += 1;
                $result['monthly']['not_eligible'][$monthly] += 1;
                $result['weekly']['not_eligible'][$weekly]   += 1;
            }
        }

        return $result;
    }
}
