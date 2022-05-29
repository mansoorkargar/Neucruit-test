<?php

declare (strict_types = 1);

namespace App\Repositories;

use App\Models\CampaignType;

/**
 * Campaign Type Repository class
 */
class CampaignTypeRepository extends AbstractRepository
{
    /**
     * @var CampaignType
     */
    protected $model;
    /**
     * Call parent construct with binding Model
     */
    public function __construct()
    {
        $this->model = new CampaignType();
        parent::__construct($this->model);
    }
}
