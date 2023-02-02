<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(Private UserService $userService)
    {}

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('app', ['user'])->plainTextToken;
            $this->userService->setLoggedOutAt($user, null);

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

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        $this->userService->setLoggedOutAt($user, Carbon::now());

        return new JsonResponse([
            'message' => 'Logout successful.'
        ]);
    }
}
