<?php

namespace App\Classes\Contracts\Services;

use App\Models\Study;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface StudyCampaignService
{
    /**
     * Get campaigns by a study
     *
     * @param Study $study Study
     *
     * @return HasMany
     */
    public function getCampaignsByStudy(Study $study): HasMany;
}
