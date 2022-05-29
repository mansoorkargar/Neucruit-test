<?php

declare (strict_types = 1);

namespace App\Repositories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;

/**
 * Campaign Repository class
 */
class CampaignRepository extends AbstractRepository
{
    /**
     * @var Campaign
     */
    protected $model;
    /**
     * Call parent construct with binding Model
     */
    public function __construct()
    {
        $this->model = new Campaign();
        parent::__construct($this->model);
    }

    /**
     * Get all records with relation data
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->with('type')->get();
    }
}
