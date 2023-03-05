<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyStoreRequest;
use App\Http\Requests\ReplyUpdateRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function index(int $threadId): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        $thread = null;
        $replies = [];
        $relations = ['user'];

        if($user?->can('view all threads') && $user?->can('view all forums')) {
            $thread = Thread::findOrFail($threadId);
        } else {
            $thread = Thread::published($user)
                ->whereHas('forum', function(Builder $query) use ($user) {
                    $query->published($user);
                })
                ->findOrFail($threadId);
        }

        $replies = $thread->replies()->with($relations)->get();

        return new JsonResponse([
            'replies' => ReplyResource::collection($replies)
        ]);
    }

    public function store(ReplyStoreRequest $request, int $threadId): JsonResponse
    {
        $thread = Thread::findOrFail($threadId);

        $this->authorize('storeReply', $thread);

        $reply = new Reply($request->validated());
        $reply->user()->associate(Auth::user());
        $thread->replies()->save($reply);
        $reply->save();

        return new JsonResponse([
            'message' => 'The reply has been created successfully.',
            'reply' => new ReplyResource($reply)
        ], 201);
    }

    public function update(ReplyUpdateRequest $requet, int $id): JsonResponse
    {
        $reply = Reply::findOrFail($id);

        $this->authorize('update', $reply);

        $reply->update($requet->validated());
        $reply->save();

        return new JsonResponse([
            'message' => 'The reply has been updated successfully.',
            'reply' => new ReplyResource($reply)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $reply = Reply::findOrFail($id);

        $this->authorize('delete', $reply);

        $reply->delete();

        return new JsonResponse([
            'message' => 'The reply has been deleted successfully.',
        ]);
    }
}
