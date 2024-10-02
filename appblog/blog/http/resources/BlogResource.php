<?php
namespace AppBlog\Blog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'is_premium' => $this->resource->is_premium,
            'published_at' => $this->published_at,
        ];
    }
}