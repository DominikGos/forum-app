<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $thread = Thread::find($id);

        return new JsonResponse([
            'thread' => $thread
        ]);
    }
}
