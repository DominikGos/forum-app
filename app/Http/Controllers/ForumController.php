<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForumStoreRequest;
use App\Http\Resources\ForumResource;
use App\Models\Forum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
{
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

        //dd(asset('storage/' . $forum->image_path));

        return new JsonResponse([
            'forum' => new ForumResource($forum)
        ]);
    }

    public function store(ForumStoreRequest $request): JsonResponse 
    {
        $forum = new Forum($request->validated());
        $forum->user()->associate(Auth::user());

        if($request->file('image')) {
            $path = $request->file('image')->store('forum', 'public');
            $forum->image_path = $path;
        }

        $forum->save();

        return new JsonResponse([
            'message' => 'The forum has been successfully created.',
            'forum' => new ForumResource($forum)
        ]);
    }
}
