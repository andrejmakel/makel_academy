<?php

namespace Appchat\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_one' => $this->user_one->username,
            'user_two' => $this->user_two->username,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}