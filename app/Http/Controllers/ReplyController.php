<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index(int $threadId): JsonResponse
    {
        $thread = Thread::find($threadId);

        return new JsonResponse([
            'replies' => ReplyResource::collection($thread->replies)
        ]);
    }
}
