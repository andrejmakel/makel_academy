<?php

namespace Appchat\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'message_id' => $this->id,
            'sender_name' => $this->sender->username,
            'sent_at' => $this->created_at->toDateTimeString(),
            'text' => $this->text,
            'reactions' => $this->reactions->pluck('emoji'),
            'replies' => $this->replies->pluck('text'),
            'file_url' => $this->attachment ? $this->attachment->getUrl() : null,
        ];
    }
}