<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'image' => asset('storage/' . $this->image_path),
            'publishedAt' => $this->published_at,
            'timestamps' => new TimestampsResource($this),
            'user' => new UserResource($this->whenLoaded('user')),
            'threadCount' => $this->whenCounted('threads'),
        ];
    }
}
