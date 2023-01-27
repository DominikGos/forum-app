<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index(): JsonResponse
    {
        $replies = Reply::all();

        return new JsonResponse([
            'replies' => $replies
        ]);
    }
}
