<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(int $id): JsonResponse {
        $user = User::find($id);

        dd(Thread::first()->tags);

        return new JsonResponse([
            'user' => $user
        ]);
    }
}
