<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ReplyResource;
use App\Http\Resources\ThreadResource;
use App\Http\Resources\UserResource;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private const DISK = 'public';
    private const USER_FILES_DIRECTORY = 'user';

    public function show(int $id): JsonResponse
    {
        $user = User::withCount(['createdForums', 'threads', 'replies'])->findOrFail($id);
        $user->load('roles');
        
        return new JsonResponse([
            'user' => new UserResource($user)
        ]);
    }

    public function threads(int $userId): JsonResponse
    {
        $user = null;
        $authUser = Auth::guard('sanctum')->user();

        if ($authUser?->can('view all threads')) {
            $user = User::with(['threads.user', 'threads' => function ($query) {
                $query->withCount('replies');
            }])
                ->findOrFail($userId);
        } else {
            $user = User::with(['threads.user', 'threads' => function ($query) use ($authUser) {
                $query->published($authUser)->withCount('replies');
            }])
                ->findOrFail($userId);
        }

        $threads = $user?->threads;

        return new JsonResponse([
            'threads' => ThreadResource::collection($threads)
        ]);
    }

    public function replies(int $userId): JsonResponse
    {
        $user = null;
        $authUser = Auth::guard('sanctum')->user();

        if ($authUser?->can('view all threads')) {
            $user = User::with(['replies', 'replies.thread'])->findOrFail($userId);
        } else {
            $user = User::with(['replies.thread', 'replies' => function($query) use ($authUser) {
                $query->whereHas('thread', function (Builder $query) use ($authUser) {
                    $query->published($authUser);
                });
            }])->findOrFail($userId);
        }

        $replies = $user?->replies;

        return new JsonResponse([
            'replies' => ReplyResource::collection($replies)
        ]);
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return new JsonResponse([
            'users' => UserResource::collection($users)
        ]);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user->update($request->validated());

        if ($request->file('avatar')) {
            $avatarPath = $request->file('avatar')->store(self::USER_FILES_DIRECTORY, self::DISK);
            $user->avatar_path = $avatarPath;
        }

        if ($request->deleteAvatar) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->save();

        return new JsonResponse([
            'message' => 'Updated successfully.',
            'user' => new UserResource($user),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $this->authorize('destroy', $user);

        $user->delete();

        return new JsonResponse([
            'message' => 'The user has been successfully deleted.'
        ]);
    }

    public function joinForum(int $id): JsonResponse
    {
        $forum = Forum::findOrFail($id);

        $this->authorize('joinForum', $forum);

        if (Auth::user()->forums->contains($forum)) {
            return new JsonResponse([
                'message' => 'You already belong to the forum.'
            ]);
        }

        $forum->users()->attach(Auth::user());

        return new JsonResponse([
            'message' => 'You have successfully joined to the forum.'
        ], 201);
    }

    public function leaveForum(int $id): JsonResponse
    {
        $forum = Forum::findOrFail($id);

        $this->authorize('leaveForum', $forum);

        if (!Auth::user()->forums->contains($forum)) {
            return new JsonResponse([
                'message' => "You don't belong to the forum."
            ]);
        }

        $forum->users()->detach(Auth::user());

        return new JsonResponse([
            'message' => 'You have successfully leaved the forum.'
        ]);
    }
}
