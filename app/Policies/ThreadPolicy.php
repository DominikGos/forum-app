<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function view(?User $user, Thread $thread)
    {
        if(optional($user)->can('view all threads')) {
            return true;
        }

        if(optional($user)->id == $thread->user->id) {
            return true;
        }

        return false;
    }
}
