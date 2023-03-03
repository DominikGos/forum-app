<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumUserController extends Controller
{
    public function users(int $forumId): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);

        return new JsonResponse([
            'users' => UserResource::collection($forum->users)
        ]);
    }

    public function addUser(int $forumId, int $id): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);

        $this->authorize('addUser', $forum);

        $user = User::findOrFail($id);
        $forum->users()->attach($user);

        return new JsonResponse([
            'message' => 'User with id equal ' . $user->id . ' has been successfully added to the forum.'
        ], 201);
    }

    public function removeUser(int $forumId, int $id): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);

        $this->authorize('removeUser', $forum);

        $user = User::findOrFail($id);
        $forum->users()->detach($user);

        return new JsonResponse([
            'message' => 'User with id equal ' . $user->id . ' has been successfully removed from the forum.'
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
