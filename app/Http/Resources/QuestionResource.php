<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->resource->id,
            'recruiting'        => $this->resource->recruiting,
            'study_question'    => $this->resource->study_question,
            'study_description' => $this->resource->study_description,
            'copy_paste'        => $this->resource->copy_paste,
            'studyLink'         => $this->resource->study_link,
            'studyMinutes'      => $this->resource->study_minutes,
            'study_start'       => $this->resource->study_start,
            'studyend'          => $this->resource->study_end,
            'participants'      => $this->resource->participants,
            'looking_for'       => $this->resource->looking_for,
            'study_part'        => $this->resource->study_part,
            'notes'             => $this->resource->notes,
            'questions'         => $this->resource->questions,
        ];

    }
}
