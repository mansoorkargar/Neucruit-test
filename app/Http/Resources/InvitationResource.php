<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
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
            'email'        => $this->email,
            'is_expired'   => $this->isExpired(),
            'first_letter' => $this->getFirstLetter(),
        ];
    }
}
