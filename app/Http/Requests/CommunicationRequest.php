<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommunicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'template_name' => 'required|min:1',
            'email_subject' => 'required|min:1',
            'file'          => 'nullable',
            'enabled'       => 'nullable',
            'content'       => 'required|min:1',
        ];
    }
}
