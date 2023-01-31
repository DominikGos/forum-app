<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(int $id): JsonResponse {
        $user = User::findOrFail($id);

        return new JsonResponse([
            'user' => new UserResource($user)
        ]);
    }

    public function index(): JsonResponse {
        $users = User::all();

        return new JsonResponse([
            'users' => UserResource::collection($users)
        ]);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse //add authorization!
    {
        User::findOrFail($id)->update($request->validated());

        return new JsonResponse([
            'message' => 'Updated successfully.'
        ]);
    }
}
