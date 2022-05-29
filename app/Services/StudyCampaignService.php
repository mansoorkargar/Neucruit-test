<?php

namespace App\Services;

use App\Models\Study;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Classes\Contracts\Services\StudyCampaignService as StudyCampaignServiceContract;

class StudyCampaignService implements StudyCampaignServiceContract
{
    /**
     * Get campaigns by a study
     * 
     * @param Study $study Study
     * 
     * @return HasMany
     */
    public function getCampaignsByStudy(
        Study $study
    ): HasMany {
        return $study->campaigns();
    }
}
