<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'content' => $this->content,
            'likes' => $this->likes,
            'isAccepted' => $this->is_accepted,
            'timestamps' => new TimestampsResource($this),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
