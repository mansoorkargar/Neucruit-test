<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunicationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'template_name' => $this->resource->template_name,
            'email_subject' => $this->resource->email_subject,
            'enabled' => $this->resource->enabled,
            'file' => $this->resource->file,
            'content' => $this->resource->content,
        ];
    }
}
