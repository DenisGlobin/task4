<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'payload' => json_decode($this->payload),
            'owner' => $this->user,
            'createdAt' => $this->created_at,
            'modifyAt' => $this->modify_at
        ];
    }

}
