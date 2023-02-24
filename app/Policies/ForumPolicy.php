<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Forum $forum): bool
    {
        if(optional($user)->can('view own forums') && optional($user)->id == $forum->user->id) {
            return true;
        }

        if(optional($user)->can('view all forums')) {
            return true;
        }

        return false;
    }

    public function update(User $user, Forum $forum): bool
    {
        if($user->can('edit own forums') && $user->id == $forum->user_id) {
            return true;
        }

        if($user->can('edit all forums')) {
            return true;
        }

        return false;
    }

    public function destroy(User $user, Forum $forum): bool
    {
        if($user->can('delete own forums') && $user->id == $forum->user_id) {
            return true;
        }

        if($user->can('delete all forums')) {
            return true;
        }

        return false;
    }

    public function storeThread(User $user, Forum $forum): bool
    {
        if($user->can('create own threads') && $user->forums->contains($forum) && $forum->isPublished()) {
            return true;
        }

        if($user->hasAllRoles(['admin', 'editor'])) {
            return true;
        }

        return false;
    }

    public function addUser(User $user, Forum $forum): bool
    {
        if($user->can('add users to all forums')) {
            return true;
        }

        return false;
    }

    public function removeUser(User $user, Forum $forum): bool
    {
        if($user->can('remove users from own forum') && $user->id == $forum->user->id && $forum->isPublished()) {
            return true;
        }

        if($user->can('remove users from all forums')) {
            return true;
        }

        return false;
    }
}
