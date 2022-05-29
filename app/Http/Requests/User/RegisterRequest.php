<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'         => 'required',
            'last_name'    => 'required',
            'company'      => 'required',
            'phone_number' => 'filled|numeric',
            'email'        => 'unique:users|required|email',
            'password'     => ['required', 'confirmed', Password::min(8)->numbers()->symbols()],
            'token'        => [
                'nullable',
                Rule::exists('invitations', 'token')->where(function ($query) {
                    return $query->where('email', $this->email);
                }),
            ]
        ];
    }
}
