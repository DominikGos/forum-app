<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $password = Hash::make($request->password);

        $userData = array_merge($request->all(), ['password' => $password]);

        $user = User::create($userData);

        $token = $user->createToken('app', ['user'])->plainTextToken;

        return new JsonResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }
}
