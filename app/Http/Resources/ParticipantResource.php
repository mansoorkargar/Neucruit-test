<?php

namespace App\Http\Resources;

use App\Enums\GenderEnum;
use Illuminate\Http\Request;
use App\Enums\CommunicationTriggerEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'status'            => CommunicationTriggerEnum::getById($this->status_id),
            'gender'            => GenderEnum::getById($this->gender_id),
            'reference_number'  => $this->reference_number,
            'age'               => $this->age,
            'ethnicity'         => $this->ethnicity,
            'phone_number'      => $this->phone_number,
            'site'              => $this->site,
            'site_distance'     => $this->site_distance,
            'opt_in'            => $this->opt_in,
            'contact_date'      => $this->contact_date,
            'confirmation_date' => $this->confirmation_date,
            'symptoms_date'     => $this->symptoms_date,
            'suspect_date'      => $this->suspect_date,
            'form_sent'         => $this->form_sent,
            'screening_data'    => $this->screening_data,
            'country'           => $this->country,
            'city'              => $this->city,
            'postcode'          => $this->postcode,
            'address_line_1'    => $this->address_line_1,
            'address_line_2'    => $this->address_line_2,
            'birthdate'         => $this->birthdate,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
