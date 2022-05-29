<?php

namespace App\Services;

use App\Models\Advocates;
use App\Classes\Contracts\Services\AdvocatesService as AdvocatesServiceContract;

class AdvocatesService implements AdvocatesServiceContract
{
    /**
     * @param $search
     * @return array
     */
    public function list($search): array
    {
        if ($search) {
            return [
                'success' => true,
                'data' => Advocates::query()->where('name',  'like', '%' . $search . '%')->get()
            ];
        } else {
            return [
                'success' => true,
                'data' => Advocates::query()->get()
            ];
        }
    }
}
