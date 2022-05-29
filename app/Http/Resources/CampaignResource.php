<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * @param Request $request
     * 
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'study_id'     => $this->study_id,
            'name'         => $this->name,
            'type'         => $this->type,
            'slug'         => $this->slug,
            'starts_at'    => $this->starts_at,
            'ends_at'      => $this->ends_at,
            'status'       => $this->getStatus(),
        ];
    }
}
