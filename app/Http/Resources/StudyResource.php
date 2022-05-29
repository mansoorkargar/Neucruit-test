<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            'trial_id'               => $this->trial_id,
            'participants_total'     => $this->participants()->count(), 
            'participants_this_week' => $this->getParticipantsThisWeek(),  
            'days_left'              => $this->getDaysLeft(),
            'conversion_rate'        => $this->getConversionRate(),
            'demographics'           => [
                'by_gender'    => $this->getDemographicsByGender(),
                'by_age'       => $this->getDemographicsByAge(),
                'by_ethnicity' => $this->getDemographicsByEthnicity(),
            ],
            'channels' => [
                'last_15_days' => $this->getChannelConversionLast15Days(),
                'last_month'   => $this->getChannelConversionLastMonth(),
                'last_year'    => $this->getChannelConversionLastYear(),
            ],
            'realtime' => $this->getRealTimeProgress(),    
        ];
    }
}
