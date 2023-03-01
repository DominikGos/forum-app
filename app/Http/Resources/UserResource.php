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
        $avatarPath = null;
        
        if($this->avatar_path) {
            $avatarPath = asset('storage/' . $this->avatar_path);
        }

        return [
            'id' => $this->id,
            'email' => $this->email,
            'login' => $this->login,
            'avatarPath' => $avatarPath,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'description' => $this->description,
            'roles' => $this->whenLoaded('roles', $this->getRoleNames()),
            'loggedOutAt' => $this->logged_out_at,
            'timestamps' => new TimestampsResource($this),
            'createdForumCount' => $this->whenCounted('createdForums'),
            'threadCount' => $this->whenCounted('threads'),
            'replieCount' => $this->whenCounted('replies'),
        ];
    }
}
