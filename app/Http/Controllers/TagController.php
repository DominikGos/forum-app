<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::all();

        return new JsonResponse([
            'tags' => TagResource::collection($tags)
        ]);
    }

    public function store(TagStoreRequest $request): JsonResponse
    {
        $tag = new Tag($request->validated());
        $tag->user()->associate(Auth::user());
        $tag->save();

        return new JsonResponse([
            'message' => 'The tag has been successfuly created.',
            'tag' => new TagResource($tag)
        ], 201);
    }

   /*  public function update(): JsonResponse
    {
        return new JsonResponse([
            'tag' => TagResource::collection($tag)
        ]);
    }

    public function destroy(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'The tag has been removed successfully.'
        ]);
    } */
}
