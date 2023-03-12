<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

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
        $threadCount = $this->whenCounted('publishedThreads');

        if( ! is_numeric($threadCount) && get_class($threadCount) === MissingValue::class) {
            $threadCount = $this->whenCounted('threads');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => asset('storage/' . $this->image_path),
            'publishedAt' => $this->published_at,
            'timestamps' => new TimestampsResource($this),
            'user' => new UserResource($this->whenLoaded('user')),
            'threadCount' => $threadCount,
        ];
    }
}
