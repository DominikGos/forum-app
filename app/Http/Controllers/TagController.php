<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
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

    public function update(TagUpdateRequest $request, int $id): JsonResponse
    {
        $tag = Tag::findOrFail($id);
        $tag->update($request->validated());
        $tag->save();

        return new JsonResponse([
            'message' => 'The tag has been successfuly updated.',
            'tag' => new TagResource($tag)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return new JsonResponse([
            'message' => 'The tag has been successfully deleted .'
        ]);
    }
}
