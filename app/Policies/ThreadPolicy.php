<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Thread $thread): bool
    {
        if($thread->isPublished()) {
            return true;
        }
        
        if(optional($user)->can('view own threads') && optional($user)->id == $thread->user->id) {
            return true;
        }

        if(optional($user)->can('view all threads')) {
            return true;
        }

        return false;
    }

    public function update(User $user, Thread $thread): bool
    {
        if($user->can('edit own threads') && $user->id == $thread->user_id) {
            return true;
        }

        if($user->can('edit all threads')) {
            return true;
        }

        return false;
    }

    public function destroy(User $user, Thread $thread): bool
    {
        if($user->can('delete own threads') && $user->id == $thread->user_id) {
            return true;
        }

        if($user->createdForums->contains($thread->forum)) {
            return true;
        }

        if($user->can('delete all threads')) {
            return true;
        }

        return false;
    }

    public function storeReply(User $user, Thread $thread): bool
    {
        if($user->can('create own replies') && $thread->isPublished()) {
            return true;
        }

        if($user->hasAllRoles(['admin', 'editor'])) {
            return true;
        }

        return false;
    }
}
