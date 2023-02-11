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
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private const DISK = 'public';
    private const USER_FILES_DIRECTORY = 'user';

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

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        if($request->file('avatar')) {
            $avatarPath = $request->file('avatar')->store(self::USER_FILES_DIRECTORY, self::DISK);
            $user->avatar_path = $avatarPath;
        }

        if($request->deleteAvatar) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->save();

        return new JsonResponse([
            'message' => 'Updated successfully.',
            'user' => new UserResource($user),
        ]);
    }

    public function destroy(int $id): JsonResponse //add authorization!
    {
        $user = User::findOrFail($id);

        $user->delete();

        return new JsonResponse([
            'message' => 'The user has been successfully deleted.'
        ]);
    }
}
