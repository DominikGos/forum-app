<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadStoreRequest;
use App\Http\Requests\ThreadUpdateRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Forum;
use App\Models\Like;
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
    {
    }

    public function index(int $forumId): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $relations = ['user'];
        $forum = null;
        $threads = [];

        if ($user?->can('view all threads') && $user?->can('view all forums')) {
            $forum = Forum::findOrFail($forumId);

            $threads = $forum
                ->threads()
                ->with($relations)
                ->withCount('replies')
                ->get();
        } else {
            $forum = Forum::published($user)->findOrFail($forumId);

            $threads = $forum
                ->threads()
                ->published($user)
                ->with($relations)
                ->withCount('replies')
                ->get();
        }

        return new JsonResponse([
            'threads' => ThreadResource::collection($threads)
        ]);
    }

    public function show(int $forumId, int $threadId): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $relations = ['tags', 'forum', 'user'];
        $forum = null;
        $thread = null;

        if($user?->can('view all threads') && $user?->can('view all forums')) {
            $forum = Forum::findOrFail($forumId);

            $thread = $forum
                ->threads()
                ->with($relations)
                ->findOrFail($threadId);
        } else {
            $forum = Forum::published($user)->findOrFail($forumId);

            $thread = $forum
                ->threads()
                ->with($relations)
                ->whereHas('forum', function(Builder $query) use ($user) {
                    $query->published($user);
                })
                ->published($user)
                ->findOrFail($threadId);
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

    public function like(int $id): JsonResponse
    {
        $thread = Thread::findOrFail($id);

        if($thread->likes()->where('user_id', Auth::id())->exists()) {
            return new JsonResponse([
                'message' => 'You already like that thread.',
            ], 422);
        }

        $like = new Like();
        $like->user()->associate(Auth::user());
        $thread->likes()->save($like);

        return new JsonResponse([
            'reply' => new ThreadResource($thread)
        ]);
    }

    public function unlike(int $id): JsonResponse
    {
        $thread = Thread::findOrFail($id);

        if($thread->likes()->where('user_id', Auth::id())->exists()) {
            $like = $thread->likes()->where('user_id', Auth::id())->first();
            $thread->likes()->delete($like);

            return new JsonResponse([
                'reply' => new ThreadResource($thread)
            ]);
        }

        return new JsonResponse([
            'message' => 'You have to like that thread.',
        ], 422);
    }
}
