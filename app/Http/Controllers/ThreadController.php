<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function show(): JsonResponse
    {
        $thread = Thread::all();

        return new JsonResponse([
            'thread' => $thread
        ]);
    }
}
