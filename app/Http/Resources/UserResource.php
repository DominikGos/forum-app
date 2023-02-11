<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'login' => $this->login,
            'avatarPath' => asset('storage/' . $this->avatar_path),
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'description' => $this->description,
            'loggedOutAt' => $this->logged_out_at,
            'timestamps' => new TimestampsResource($this),
        ];
    }
}
