<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    public function storeThread(User $user, Forum $forum): bool
    {
        $userForumIds = array_map(function(array $userForum) {
            return $userForum['id'];
        }, $user->forums->toArray());

        if($user->can('create own threads') && in_array($forum->id, $userForumIds)) {
            return true;
        }

        return false;
    }
}
