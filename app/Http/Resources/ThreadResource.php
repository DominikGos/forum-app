<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'likes' => $this->likes,
            'timestamps' => new TimestampsResource($this),
            'user' => new UserResource($this->user),
            'forum' => new ForumResource($this->forum),
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
