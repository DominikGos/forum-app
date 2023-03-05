<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ReplyResource extends JsonResource
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
            'content' => $this->content,
            'likes' => $this->likes()->count(),
            'isLikedByUser' => $isLikedByUser,
            'isAccepted' => $this->is_accepted,
            'timestamps' => new TimestampsResource($this),
            'user' => new UserResource($this->whenLoaded('user')),
            'thread' => new ThreadResource($this->whenLoaded('thread')),
        ];
    }
}
