<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $password = Hash::make($request->validated('password'));
        $userData = array_merge($request->validated(), ['password' => $password]);
        $user = User::create($userData);
        $user->assignRole('contributor');
        $token = $user->createToken('app', ['user'])->plainTextToken;
        Auth::guard('sanctum')->setUser($user);

        return new JsonResponse([
            'message' => 'Successful registration.',
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }
}
