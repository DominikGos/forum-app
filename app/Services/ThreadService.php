<?php

namespace App\Services;

use App\Models\Thread;
use Carbon\Carbon;

class ThreadService
{
    public function setPublishedAt(int $id, ?Carbon $date): Thread
    {
        $relations = ['tags', 'forum', 'user'];
        $thread = Thread::with($relations)->findOrFail($id);
        $thread->published_at = $date;
        $thread->save();

        return $thread;
    }
}
