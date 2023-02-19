<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadStoreRequest;
use App\Http\Requests\ThreadUpdateRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use App\Services\ThreadService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ThreadController extends Controller
{
    public function __construct(private ThreadService $threadService)
    {}

    public function index(int $forumId): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $relations = ['threads.user'];

        if($user?->can('view all threads')) {
            $forum = Forum::with($relations)->findOrFail($forumId);
            $threads = $forum->threads;
        } else {
            $relations = implode(', ', $relations);

            $forum = Forum::with([
                $relations, 'threads' => function($query) use ($user) {
                    if($user) {
                        $query->where('user_id', $user->id)->orWhereNotNull('published_at');
                    } else {
                        $query->whereNotNull('published_at');
                    }
                }
            ])
            ->where('published_at', '!=', null)
            ->findOrFail($forumId);

            $threads = $forum->threads;
        }

        return new JsonResponse([
            'threads' => ThreadResource::collection($threads)
        ]);
    }

    public function show(int $forumId, int $threadId): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $relations = ['tags', 'forum', 'user'];
        $forum = Forum::findOrFail($forumId);
        $thread = Thread::with($relations)->findOrFail($threadId);

        if($thread->forum->id != $forum->id) {
            return new JsonResponse(null, 404);
        }

        if( ! $user || $user?->cannot('view', $thread)) {
            $thread = Thread::with($relations)->whereNotNull('published_at')->findOrFail($threadId);
        }

        return new JsonResponse([
            'thread' => new ThreadResource($thread)
        ]);
    }


    public function store(ThreadStoreRequest $request, int $forumId): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);

        $this->authorize('storeThread', $forum);

        $thread = new Thread($request->validated());
        $thread->user()->associate(Auth::user());
        $forum->threads()->save($thread);
        $thread->save();
        $thread->tags()->attach($request->tagIds);

        return new JsonResponse([
            'message' => 'Thread created successfully.',
            'thread' => new ThreadResource($thread)
        ], 201);
    }

    public function update(ThreadUpdateRequest $request, int $id): JsonResponse
    {
        $thread = Thread::findOrFail($id);

        $this->authorize('update', $thread);

        $thread->update($request->validated());
        $thread->tags()->sync($request->tagIds);

        return new JsonResponse([
            'message' => 'The thread has been successfully updated.',
            'thread' => new ThreadResource($thread)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $thread = Thread::findOrFail($id);

        $this->authorize('destroy', $thread);

        $thread->delete();

        return new JsonResponse([
            'message' => 'The thread has been successfully deleted.'
        ]);
    }

    public function publish(int $id): JsonResponse
    {
        $this->authorize('publish all threads');

        $thread = $this->threadService->setPublishedAt($id, Carbon::now());

        return new JsonResponse([
            'message' => 'The thread has been successfully published.',
            'thread' => new ThreadResource($thread)
        ]);
    }

    public function unpublish(int $id): JsonResponse
    {
        $this->authorize('publish all threads');

        $thread = $this->threadService->setPublishedAt($id, null);

        return new JsonResponse([
            'message' => 'The thread has been successfully unpublished.',
            'thread' => new ThreadResource($thread)
        ]);
    }
}
