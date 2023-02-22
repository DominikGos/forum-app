<?php

namespace Tests;

use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use RefreshDatabase;

    protected $seed = true;
    protected ?User $userWithoutRole;
    protected ?User $editor;
    protected ?User $contributor;
    protected ?Thread $publishedThread;
    protected ?Thread $unpublishedThread;
    protected ?Forum $publishedForum;
    protected ?Forum $unpublishedForum;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userWithoutRole = User::factory()->create();
        $this->editor = User::role('editor')->first();
        $this->contributor = User::role('contributor')->first();
        $this->publishedThread = Thread::whereNotNull('published_at')->first();
        $this->unpublishedThread = Thread::whereNull('published_at')->first();
        $this->publishedForum = Forum::whereNotNull('published_at')->first();
        $this->unpublishedForum = Forum::whereNull('published_at')->first();
    }

}
