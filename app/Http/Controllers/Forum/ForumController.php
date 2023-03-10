<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumStoreRequest;
use App\Http\Requests\ForumUpdateRequest;
use App\Http\Resources\ForumResource;
use App\Models\Forum;
use App\Services\ForumService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::guard('sanctum')->user();
        $relations = ['user'];
        $forums = [];

        if($user?->can('view all forums')) {
            $forums = Forum::with($relations)
                ->withCount('threads')
                ->get();
        } else {
            $forums = Forum::with($relations)
                ->withCount('publishedThreads')
                ->published()
                ->get();
        }

        return new JsonResponse([
            'forums' => ForumResource::collection($forums)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $relations = ['user'];
        $forum = Forum::with($relations)->findOrFail($id);

        if( ! $user || $user->cannot('view', $forum)) {
            $forum = Forum::with($relations)
                ->withCount('publishedThreads')
                ->published()
                ->findOrFail($id);
        } else if($user?->can('view all forums')) {
            $forum->loadCount('threads');
        }

        return new JsonResponse([
            'forum' => new ForumResource($forum)
        ]);
    }

    public function store(ForumStoreRequest $request): JsonResponse
    {
        $this->authorize('create own forums');

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

        $this->authorize('update', $forum);

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

        $this->authorize('destroy', $forum);

        $forum->delete();

        return new JsonResponse([
            'message' => 'The forum has been successfully deleted.'
        ]);
    }

    public function publish(int $id): JsonResponse
    {
        $this->authorize('publish all forums');

        $forum = $this->forumService->setPublishedAt($id, Carbon::now());

        return new JsonResponse([
            'message' => 'The forum has been successfully published.',
            'forum' => new ForumResource($forum)
        ]);
    }

    public function unpublish(int $id): JsonResponse
    {
        $this->authorize('unpublish all forums');

        $forum = $this->forumService->setPublishedAt($id, null);

        return new JsonResponse([
            'message' => 'The forum has been successfully published.',
            'forum' => new ForumResource($forum)
        ]);
    }
}
