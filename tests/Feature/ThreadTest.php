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

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_unpublished_threads()
    {
        $forum = Forum::first();

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_authorized_user_can_view_unpublished_threads()
    {
        $user = User::role('editor')->first();
        $forum = Forum::first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_view_unpublished_threads()
    {
        $unauthorizedUser = User::role('contributor')->first();
        $forum = Forum::first();

        Sanctum::actingAs($unauthorizedUser);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_author_can_view_his_own_unpublished_threads()
    {
        $user = User::role('contributor')->first();
        $unpublishedThread = Thread::factory()
            ->for(Forum::first())
            ->for($user)
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => 1]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_visitor_can_view_published_thread()
    {
        $thread = Thread::where('published_at', '!=', null)->first();

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_visitor_cannot_view_unpublished_thread()
    {
        $thread = Thread::where('published_at', null)->first();

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_thread()
    {
        $user = User::role('editor')->first();
        $thread = Thread::where('published_at', null)->first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_user_cannot_view_unpublished_thread()
    {
        $user = User::role('contributor')->first();
        $thread = Thread::where('published_at', null)->first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));
        $response->assertNotFound();
    }

    public function test_author_can_view_his_own_unpublished_thread()
    {
        $user = User::role('contributor')->first();
        $thread = Thread::factory()
            ->for($user)
            ->for(Forum::first())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));
        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_user_can_store_thread()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::first();
        $thread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertCreated()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_user_cannot_store_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->make();
        $forum = Forum::first();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_update_someone_thread()
    {
        $user = User::role('editor')->first();
        $thread = Thread::first();
        $updatedThread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertOk()->assertJsonPath('thread.title', $updatedThread->title);
    }

    public function test_unauthorized_user_cannot_update_someone_thread()
    {
        $unauthorizedUser = User::role('contributor')->first();
        $thread = Thread::first();
        $updatedThread = Thread::factory()->make();

        Sanctum::actingAs($unauthorizedUser);

        $response = $this->putJson(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertForbidden();
    }

    public function test_author_can_update_own_thread()
    {
        $user = User::has('threads', '>', 0)->first();
        $updatedThread = Thread::factory()->make();
        $thread = $user->threads()->first();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertOk()->assertJsonPath('thread.title', $updatedThread->title);
    }

    public function test_authorized_user_can_delete_someone_thread()
    {
        $user = User::role('editor')->first();
        $thread = Thread::first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('threads.destroy', ['id' => $thread->id]));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_delete_someone_thread()
    {
        $user = User::role('contributor')->first();
        $thread = Thread::first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('threads.destroy', ['id' => $thread->id]));

        $response->assertForbidden();
    }

    public function test_author_can_delete_own_thread()
    {
        $user = User::has('threads', '>', 0)->first();
        $thread = $user->threads()->first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('threads.destroy', ['id' => $thread->id]));

        $response->assertOk();
    }
}
