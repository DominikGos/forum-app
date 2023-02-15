<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForumStoreRequest;
use App\Http\Requests\ForumUpdateRequest;
use App\Http\Resources\ForumResource;
use App\Http\Resources\UserResource;
use App\Models\Forum;
use App\Models\User;
use App\Services\ForumService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
{
    private const DISK = 'public';
    private const FORUM_FILES_DIRECTORY = 'forum';
    private ForumService $forumService;

    public function __construct()
    {
        $this->forumService = new ForumService(self::FORUM_FILES_DIRECTORY, self::DISK);
    }

    public function index(): JsonResponse
    {
        $forums = Forum::with('user')->get();

        return new JsonResponse([
            'forums' => ForumResource::collection($forums)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $forum = Forum::with('user')->findOrFail($id);

        return new JsonResponse([
            'forum' => new ForumResource($forum)
        ]);
    }

    public function store(ForumStoreRequest $request): JsonResponse
    {
        $forum = new Forum($request->validated());
        $forum->user()->associate(Auth::user());

        if($request->file('image')) {
            $this->forumService->saveFile($forum, $request->file('image'));
        }

        $forum->save();
        $forum->users()->attach(Auth::user());

        return new JsonResponse([
            'message' => 'The forum has been successfully created.',
            'forum' => new ForumResource($forum)
        ], 201);
    }

    public function update(ForumUpdateRequest $request, int $id): JsonResponse
    {
        $forum = Forum::findOrFail($id);
        $forum->update($request->validated());

        if($request->file('image')) {
            $this->forumService->saveFile($forum, $request->file('image'));
        }

        $forum->save();

        return new JsonResponse([
            'message' => 'The forum has been successfully updated.',
            'forum' => new ForumResource($forum)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        return new JsonResponse([
            'message' => 'The forum has been successfully deleted.'
        ]);
    }

    public function publish(int $id): JsonResponse
    {
        $forum = $this->forumService->setPublishedAt($id, Carbon::now());

        return new JsonResponse([
            'message' => 'The forum has been successfully published.',
            'forum' => new ForumResource($forum)
        ]);
    }

    public function unpublish(int $id): JsonResponse
    {
        $forum = $this->forumService->setPublishedAt($id, null);

        return new JsonResponse([
            'message' => 'The forum has been successfully published.',
            'forum' => new ForumResource($forum)
        ]);
    }

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
        $user = User::findOrFail($id);
        $forum->users()->attach($user);

        return new JsonResponse([
            'message' => 'User with id equal ' . $user->id . ' has been successfully added to the forum.'
        ], 201);
    }

    public function removeUser(int $forumId, int $id): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);
        $user = User::findOrFail($id);
        $forum->users()->detach($user);

        return new JsonResponse([
            'message' => 'User with id equal ' . $user->id . ' has been successfully remove from the forum.'
        ]);
    }
}
