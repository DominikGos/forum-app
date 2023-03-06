<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $isLikedByUser = $this->likes()->where('user_id', Auth::guard('sanctum')->id())->exists();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'likes' => $this->likes()->count(),
            'isLikedByUser' => $isLikedByUser,
            'publishedAt' => $this->published_at,
            'isClosed' => $this->is_closed,
            'timestamps' => new TimestampsResource($this),
            'user' => new UserResource($this->whenLoaded('user')),
            'forum' => new ForumResource($this->whenLoaded('forum')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'replyCount' => $this->whenCounted('replies'),
        ];
    }
}
