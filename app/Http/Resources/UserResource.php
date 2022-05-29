<?php

namespace App\Http\Resources;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->getFullName(),
            'first_letter' => $this->getFirstLetter(),
            'email'        => $this->email,
            'role'         => RoleEnum::getById($this->role_id),
            'created_at'   => $this->created_at,
            'studies'      => StudyResource::collection($this->studies),
        ];
    }
}
