<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => Media::$media_type[$this->media_type],
            'title' => $this->media_title,
            'order' => $this->media_order,
            'size' => $this->media_size,
            'extension' => $this->extension,
            'file_name' => $this->file_name,
            'category_title' => $this->category_title,
            'category_slug' => $this->slug,
            'user_id' => $this->user_id,
            'user_name' => $this->name,
            'user_email' => $this->email,
        ];
    }
}
