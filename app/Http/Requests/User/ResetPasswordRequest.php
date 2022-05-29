<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->symbols()],
            'token'    => [
                'required',
                Rule::exists('password_resets', 'token'),
            ],
        ];
    }
}
