<?php

namespace App\Http\Requests\Study;

use App\Enums\GenderEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateParticipantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => ['required', 'min:2', 'max:255'],
            'email'             => ['required', 'email', Rule::unique('participants')->where(
                                        function ($query) {
                                            return $query->where('study_id', $this->route('nonAuthStudy')->id ?? 0);
                                        }
                                   )],
            'gender_id'         => ['required', 'in:' . GenderEnum::values()->implode(',')],
            'ethnicity'         => ['required', 'min:2', 'max:255'],
            'phone_number'      => ['required', 'min:2', 'max:255'],
            'contact_date'      => ['required', 'date'],
            'confirmation_date' => ['required', 'date'],
            'symptoms_date'     => ['required', 'date'],
            'suspect_date'      => ['required', 'date'],
            'country'           => ['required', 'min:2', 'max:255'],
            'city'              => ['required', 'min:2', 'max:255'],
            'postcode'          => ['required', 'min:2', 'max:255'],
            'address_line_1'    => ['required', 'min:2', 'max:255'],
            'address_line_2'    => ['required', 'min:2', 'max:255'],
            'birthdate'         => ['required', 'date'],
        ];
    }
}
