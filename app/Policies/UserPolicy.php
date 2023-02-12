<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $profile): bool
    {
        return $user->id == $profile->id;
    }

    public function destroy(User $user, User $profile): bool
    {
        if($user->id == $profile->id) {
            return true;
        }

        if($user->can('delete all users')) {
            return true;
        }

        return false;
    }
}
