<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'recruiting' => 'required',
            'studyQuestion' => 'required|max:50',
            'studyDescription' => 'required|max:1000',
            'copyPaste' => 'nullable',
            'studyLink' => 'required',
            'studyMinutes' => 'required',
            'studyStart' => 'required|date_format:Y-m-d',
            'studyEnd' => 'required|date_format:Y-m-d',
            'participants' => 'required',
            'lookingFor' => 'required',
            'studyPart' => 'required',
            'notes' => 'nullable',
            'questions' => 'required',
        ];
    }
}
