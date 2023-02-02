<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function setLoggedOutAt(User $user, ?Carbon $date = null): void
    {
        $user->logged_out_at = $date;
        $user->save();
    }
}
