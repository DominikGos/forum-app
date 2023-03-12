<?php

namespace App\Relations;

use App\Models\Thread;

trait HasPublishedThreads
{
    public function publishedThreads()
    {
        return $this->hasMany(Thread::class)->published();
    }
}
