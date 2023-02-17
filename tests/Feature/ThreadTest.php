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

    public function test_visitor_can_view_published_threads_from_the_published_forum()
    {
        $forum = Forum::where('pubished_at', '!=', null)->first();

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_unpublished_threads_from_the_published_forum()
    {
        $forum = Forum::where('pubished_at', '!=', null)->first();

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_visitor_cannot_view_published_threads_from_the_unpublished_forum()
    {
        $forum = Forum::where('pubished_at', null)->first();

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_threads_from_the_published_forum()
    {
        $user = User::role('editor')->first();
        $forum = Forum::where('pubished_at', '!=', null)->first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_view_unpublished_threads_from_the_published_forum()
    {
        $unauthorizedUser = User::role('contributor')->first();
        $forum = Forum::where('pubished_at', '!=', null)->first();

        Sanctum::actingAs($unauthorizedUser);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_user_can_view_his_own_unpublished_threads_from_the_published_forum()
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

    public function test_visitor_can_view_published_thread_from_the_published_forum()
    {
        $thread = Thread::where('published_at', '!=', null)->first();

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_visitor_cannot_view_unpublished_thread_from_the_published_forum()
    {
        $thread = Thread::where('published_at', null)->first();

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertNotFound();
    }

    public function test_visitor_cannot_view_published_thread_from_the_unpublished_forum()
    {
        $forum = Forum::where('pubished_at', null)->first();
        $thread = Thread::factory()
            ->for($forum)
            ->for(User::factory()->create())
            ->create(['published_at' => null]);

        $forum->threads()->save($thread);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_thread_from_the_published_forum()
    {
        $user = User::role('editor')->first();
        $thread = Thread::where('published_at', null)->first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertOk()
            ->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_user_can_view_unpublished_thread_from_the_unpublished_forum()
    {
        $user = User::role('editor')->first();
        $forum = Forum::where('pubished_at', null)->first();
        $thread = Thread::factory()
            ->for($forum)
            ->for(User::factory()->create())
            ->create(['published_at' => null]);

        $forum->threads()->save($thread);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));

        $response->assertOk()
            ->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_user_cannot_view_unpublished_thread_from_the_published_forum()
    {
        $user = User::role('contributor')->first();
        $thread = Thread::where('published_at', null)->first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));
        $response->assertNotFound();
    }

    public function test_user_can_view_his_own_unpublished_thread_from_the_published_forum()
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

    public function test_user_can_view_his_own_published_thread_from_the_unpublished_forum()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::where('published_at', null)->first();
        $thread = Thread::factory()
            ->for($user)
            ->for($forum)
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('threads.show', ['id' => $thread->id]));
        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_member_of_a_published_forum_can_store_thread()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::first();
        $forum->published_at = now();
        $forum->save();
        $forum->users()->save($user);
        $thread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertCreated()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_member_of_a_published_forum_cannot_store_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->make();
        $forum = Forum::first();
        $forum->published_at = now();
        $forum->save();
        $forum->users()->save($user);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertForbidden();
    }

    public function test_user_cannot_store_thread_in_the_forum_he_does_not_belong_to()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::first();
        $thread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_update_own_thread()
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

    public function test_user_can_delete_own_thread()
    {
        $user = User::has('threads', '>', 0)->first();
        $thread = $user->threads()->first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('threads.destroy', ['id' => $thread->id]));

        $response->assertOk();
    }

    public function test_authorized_user_can_publish_thread()
    {
        $user = User::role('editor')->first();
        $thread = Thread::first();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.publish', ['id' => $thread->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_publish_thread()
    {
        $user = User::role('contributor')->first();
        $thread = Thread::first();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.publish', ['id' => $thread->id]));

        $response->assertForbidden();
    }

    public function test_authorized_user_can_unpublish_thread()
    {
        $user = User::role('editor')->first();
        $thread = Thread::first();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.unpublish', ['id' => $thread->id]));

        $response->assertOk()
            ->assertJsonPath('thread.publishedAt', null);
    }

    public function test_unauthorized_user_cannot_unpublish_thread()
    {
        $user = User::role('contributor')->first();
        $thread = Thread::first();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.unpublish', ['id' => $thread->id]));

        $response->assertForbidden();
    }
}
