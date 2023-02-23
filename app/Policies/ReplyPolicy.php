<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reply $reply): bool
    {
        if($user->can('edit own replies') && $reply->user_id == $user->id) {
            return true;
        }

        if($user->can('edit all replies')) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Reply $reply): bool
    {
        if($user->can('delete own replies') && $reply->user_id == $user->id) {
            return true;
        }

        if($reply->thread->user_id == $user->id) {
            return true;
        }

        if($user->can('delete all replies')) {
            return true;
        }

        return false;
    }
}
