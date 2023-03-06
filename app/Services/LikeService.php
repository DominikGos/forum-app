<?php

namespace App\Services;

use App\Models\Like;
use App\Models\User;

class LikeService
{
    public function like(object $resource, User $user): object
    {
        $like = new Like();
        $like->user()->associate($user);
        $resource->likes()->save($like);

        return $resource;
    }

    public function unlike(object $resource, User $user): object
    {
        $like = $resource->likes()->where('user_id', $user->id)->first();
        $resource->likes()->delete($like);

        return $resource;
    }
}
