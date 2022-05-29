<?php

namespace App\Http\Requests\Study;

use Illuminate\Foundation\Http\FormRequest;

class InviteUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "emails"    => ['required', 'array', 'min:1'],
            "emails.*"  => ['required', 'email'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'emails.required' => __('global.at_least_one_email_is_required'),
            'emails.*.email'  => __('global.email_is_not_correct'),
        ];
    }

    /**
     * Additional validation rules
     *
     * @param $validator
     *
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(
            function ($validator) {
                $users = $this->route('study')->users()->pluck('email')->toArray();
                foreach ($this->emails ?? [] as $index => $email) {
                    if (in_array($email, $users)) {
                        $validator->errors()->add(
                            'emails',
                            __('global.you_have_already_invited_user_to_the_study', ['email' => $email])
                        );
                    }
                }
            }
        );
    }
}
