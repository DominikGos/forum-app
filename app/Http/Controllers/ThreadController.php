<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadStoreRequest;
use App\Http\Requests\ThreadUpdateRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ThreadController extends Controller
{
    public function index(int $forumId): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $forum = Forum::with('threads.user')->findOrFail($forumId);

        if($user?->can('view all threads')) {
            $threads = $forum->threads;
        } else {
            $threads = $forum->threads()->whereNotNull('published_at')->get();
        }

        return new JsonResponse([
            'threads' => ThreadResource::collection($threads)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $with = ['tags', 'forum', 'user'];
        $thread = Thread::with($with)->findOrFail($id);

        if($user?->cannot('view', $thread)) {
            $thread = Thread::with($with)->whereNotNull('published_at')->findOrFail($id);
        }

        return new JsonResponse([
            'thread' => new ThreadResource($thread)
        ]);
    }

    public function store(ThreadStoreRequest $request, int $forumId): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);
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
        $thread->delete();

        return new JsonResponse([
            'message' => 'The thread has been successfully deleted.'
        ]);
    }
}
