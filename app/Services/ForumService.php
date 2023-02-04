<?php

namespace App\Services;

use App\Models\Forum;
use Illuminate\Http\UploadedFile;

class ForumService
{
    public function __construct(private string $forumFilesDirectory, private string $disk)
    {}

    public function saveFile(Forum $forum, UploadedFile $file): string
    {
        $path = $file->store($this->forumFilesDirectory, $this->disk);
        $forum->image_path = $path;

        return $path;
    }
}
