<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadStoreRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Forum;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $thread = Thread::findOrFail($id);

        return new JsonResponse([
            'thread' => new ThreadResource($thread)
        ]);
    }

    public function index(int $forumId): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);
        $threads = $forum->threads;

        return new JsonResponse([
            'threads' => ThreadResource::collection($threads)
        ]);
    }

    public function store(ThreadStoreRequest $request, int $forumId): JsonResponse
    {
        $forum = Forum::findOrFail($forumId);
        $thread = new Thread($request->validated());
        $thread->user_id = Auth::id();
        $thread->forum_id = $forum->id;
        $thread->save();

        return new JsonResponse([
            'message' => 'Thread created successfully.',
            'thread' => new ThreadResource($thread)
        ], 201);
    }
}
