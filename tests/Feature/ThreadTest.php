<?php

namespace Tests\Feature;

use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_visitor_can_view_published_threads()
    {
        $forum = Forum::first();

        $response = $this->get(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_unpublished_threads()
    {
        $forum = Forum::first();

        $response = $this->get(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_authorized_user_can_view_unpublished_threads()
    {
        $user = User::role('editor')->first();
        $forum = Forum::first();
        $unpublishedThread = Thread::factory()
            ->for($forum)
            ->for(User::factory()->create())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->get(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_view_unpublished_threads()
    {
        $users = User::role('contributor')->get();
        $unauthorizedUser = $users[0];
        $user = $users[1];
        $forum = Forum::first();
        $unpublishedThread = Thread::factory()
            ->for($user)
            ->for($forum)
            ->create();

        Sanctum::actingAs($unauthorizedUser);

        $response = $this->get(route('forums.threads.index', ['forumId' => $forum->id]));

        $unpublishedThreads = $this->getUnpublishedThreads($user, $response);

        $this->assertEquals(0, count($unpublishedThreads));
        $response->assertOk();
    }

    public function test_author_can_view_his_own_unpublished_threads()
    {
        $user = User::role('contributor')->first();
        $unpublishedThread = Thread::factory()
            ->for(Forum::first())
            ->for($user)
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->get(route('forums.threads.index', ['forumId' => 1]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_authorized_user_can_view_unpublished_thread()
    {
        $user = User::role('editor')->first();
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
        $user = User::factory()->create();
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
        $user = User::role('contributor')->first();
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
        $user = User::factory()->create(); //user without any role
        $thread = Thread::factory()->make();
        $forum = Forum::first();

        Sanctum::actingAs($user);

        $response = $this->post(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ], ['Accept' => 'application/json']);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_update_someone_thread()
    {
        $user = User::role('editor')->first();
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
        $unauthorizedUser = User::factory()->create();
        $unauthorizedUser->assignRole('contributor');
        $thread = Thread::first();
        $updatedThread = Thread::factory()->make();

        Sanctum::actingAs($unauthorizedUser);

        $response = $this->put(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ], ['Accept' => 'application/json']);

        $response->assertForbidden();
    }

    public function test_author_can_update_own_thread()
    {
        $user = User::role('contributor')->where('id', 5)->first();
        $updatedThread = Thread::factory()->make();
        $thread = Thread::first();
        
        Sanctum::actingAs($user);

        $response = $this->put(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertOk()->assertJsonPath('thread.title', $updatedThread->title);
    }

    private function getUnpublishedThreads(?User $user, TestResponse $response): array
    {
        $responseContent = json_decode($response->content());
        $threads = $responseContent->threads;
        $unpublishedThreads = [];

        foreach($threads as $thread) {
            if($thread->publishedAt == null) {
                if($user && $user->id != $thread->user->id) {
                    $unpublishedThreads[] = $thread;
                } else {
                    $unpublishedThreads[] = $thread;
                }
            }
        }

        return $unpublishedThreads;
    }

}
