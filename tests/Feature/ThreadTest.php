<?php

namespace Tests\Feature;

use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_visitor_can_view_published_threads()
    {
        $response = $this->get(route('forums.threads.index', ['forumId' => 1]));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_unpublished_threads()
    {
        $response = $this->get(route('forums.threads.index', ['forumId' => 1]));

        $unpublishedThreads = $this->getUnpublishedThreads($response);

        $this->assertEquals(0, count($unpublishedThreads));
        $response->assertOk();
    }

    public function test_authorized_user_can_view_unpublished_threads()
    {
        $user = User::find(1);
        $user->assignRole('editor');

        Sanctum::actingAs($user);

        $response = $this->get(route('forums.threads.index', ['forumId' => 1]));

        $unpublishedThreads = $this->getUnpublishedThreads($response);

        $this->assertGreaterThan(0, count($unpublishedThreads));
        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_view_unpublished_threads()
    {
        $user = User::find(1); //this user has no created threads
        $user->removeRole('admin');
        $user->removeRole('editor');
        $user->assignRole('contributor');

        Sanctum::actingAs($user);

        $response = $this->get(route('forums.threads.index', ['forumId' => 1]));

        $unpublishedThreads = $this->getUnpublishedThreads($response);

        $this->assertEquals(0, count($unpublishedThreads));
        $response->assertOk();
    }

    public function test_author_can_view_his_own_unpublished_threads()
    {
        $user = User::find(2); //all forum threads belongs to him
        $user->removeRole('admin');
        $user->removeRole('editor');
        $user->assignRole('contributor');

        Sanctum::actingAs($user);

        $response = $this->get(route('forums.threads.index', ['forumId' => 1]));

        $unpublishedThreads = $this->getUnpublishedThreads($response);

        $this->assertGreaterThan(0, count($unpublishedThreads));
        $response->assertOk();
    }

    public function test_authorized_user_can_view_unpublished_thread()
    {
        $user = User::find(1);
        $user->assignRole('editor');

        $author = User::factory()->create();
        $author->assignRole('contributor');
        $thread = Thread::factory()
            ->for($author)
            ->for(Forum::first())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->get(route('threads.show', ['id' => $thread->id]));
        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_user_cannot_view_unpublished_thread()
    {
        $user = User::find(1);
        $user->removeRole('admin');
        $user->removeRole('editor');
        $user->assignRole('contributor');

        $author = User::factory()->create();
        $author->assignRole('contributor');
        $thread = Thread::factory()
            ->for($author)
            ->for(Forum::first())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->get(route('threads.show', ['id' => $thread->id]));
        $response->assertNotFound();
    }

    public function test_author_can_view_his_own_unpublished_thread()
    {
        $user = User::factory()->create();
        $user->assignRole('contributor');
        $thread = Thread::factory()
            ->for($user)
            ->for(Forum::first())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->get(route('threads.show', ['id' => $thread->id]));
        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_user_can_store_thread()
    {
        $user = User::factory()->create();
        $user->assignRole('contributor');
        $forum = Forum::first();
        $thread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->post(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ], ['Accept' => 'application/json']);

        $response->assertCreated()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_user_cannot_store_thread()
    {
        $thread = Thread::factory()->make();
        $forum = Forum::first();

        $response = $this->post(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ], ['Accept' => 'application/json']);

        $response->assertUnauthorized();
    }

    public function test_authorized_user_can_update_someone_thread()
    {
        $user = User::factory()->create();
        $user->assignRole('editor');
        $thread = Thread::first();
        $updatedThread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->put(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertOk()->assertJsonPath('thread.title', $updatedThread->title);
    }

    public function test_unauthorized_user_cannot_update_someone_thread()
    {
        $thread = Thread::first();
        $updatedThread = Thread::factory()->make();

        $response = $this->put(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ], ['Accept' => 'application/json']);

        $response->assertUnauthorized();
    }

    public function test_author_can_update_own_thread()
    {
        $user = User::factory()->create();
        $user->assignRole('contributor');
        $thread = Thread::factory()
            ->for($user)
            ->for(Forum::factory()->for($user)->create())
            ->create();

        $updatedThread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->put(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertOk()->assertJsonPath('thread.title', $updatedThread->title);
    }

    private function getUnpublishedThreads(TestResponse $response): array
    {
        $responseContent = json_decode($response->content());
        $threads = $responseContent->threads;
        $unpublishedThreads = [];

        foreach($threads as $thread) {
            if($thread->publishedAt == null) {
                $unpublishedThreads[] = $thread;
            }
        }

        return $unpublishedThreads;
    }

}
