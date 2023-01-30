<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            $token = $user->createToken('app', ['user'])->plainTextToken;

            $user->active_at = Carbon::now();
            $user->save();

            return new JsonResponse([
                'message' => 'Login successful.',
                'user' => new UserResource($user),
                'token' => $token,
            ], 200);
        }

        return new JsonResponse([
            'errors' => [
                'email' => 'These credentials do not match our records.'
            ],
        ], 422);
    }
}
