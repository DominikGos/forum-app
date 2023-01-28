<?php

namespace App\Http\Controllers;

use App\Http\Resources\ForumResource;
use App\Models\Forum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(): JsonResponse
    {
        $forums = Forum::all();

        return new JsonResponse([
            'forums' => ForumResource::collection($forums)
        ]);
    }
}
