<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadDestroyRequest;
use App\Http\Requests\ThreadStoreRequest;
use App\Http\Requests\ThreadUpdateRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
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
        $thread->user()->associate(Auth::user());
        $forum->threads()->save($thread);
        $thread->save();

        return new JsonResponse([
            'message' => 'Thread created successfully.',
            'thread' => new ThreadResource($thread)
        ], 201);
    }

    public function update(ThreadUpdateRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($request->validated('user_id'));//add authoization!
        $thread = Thread::findOrFail($id);
        $thread->update($request->validated()); //user_id param from request does not override relationship

        return new JsonResponse([
            'message' => 'The thread has been successfully updated.'
        ]);
    }

    public function destroy(ThreadDestroyRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($request->validated('user_id'));//add authoization!
        $thread = Thread::findOrFail($id);
        $thread->delete();

        return new JsonResponse([
            'message' => 'The thread has been successfully deleted.'
        ]);
    }
}
