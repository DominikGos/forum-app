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
    public function test_visitor_can_view_published_threads_from_the_published_forum()
    {
        $forum = $this->publishedForum;

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_unpublished_threads_from_the_published_forum()
    {
        $forum = $this->publishedForum;

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_visitor_cannot_view_published_threads_from_the_unpublished_forum()
    {
        $forum = $this->unpublishedForum;

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_threads_from_the_published_forum()
    {
        $user = $this->editor;
        $forum = $this->publishedForum;

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_view_unpublished_threads_from_the_published_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_user_can_view_his_own_unpublished_threads_from_the_published_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;
        $unpublishedThread = Thread::factory()
            ->for(Forum::first())
            ->for($user)
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.threads.index', ['forumId' => $forum->id]));

        $response->assertOk()->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_visitor_can_view_published_thread_from_the_published_forum()
    {
        $thread = $this->publishedThread;

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $thread->forum->id, 'id' => $thread->id])
        );

        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_visitor_cannot_view_unpublished_thread_from_the_published_forum()
    {
        $thread = $this->unpublishedThread;

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $thread->forum->id, 'id' => $thread->id])
        );

        $response->assertNotFound();
    }

    public function test_visitor_cannot_view_published_thread_from_the_unpublished_forum()
    {
        $forum = $this->unpublishedForum;
        $thread = Thread::factory()
            ->for($forum)
            ->for(User::factory()->create())
            ->create(['published_at' => null]);

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $forum->id, 'id' => $thread->id])
        );

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_thread_from_the_published_forum()
    {
        $user = $this->editor;
        $thread = $this->unpublishedThread;

        Sanctum::actingAs($user);

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $thread->forum->id, 'id' => $thread->id])
        );

        $response->assertOk()
            ->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_user_can_view_unpublished_thread_from_the_unpublished_forum()
    {
        $user = $this->editor;
        $forum = $this->unpublishedForum;
        $thread = Thread::factory()
            ->for($forum)
            ->for(User::factory()->create())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $forum->id, 'id' => $thread->id])
        );

        $response->assertOk()
            ->assertJsonPath('thread.title', $thread->title);
    }

    public function test_unauthorized_user_cannot_view_unpublished_thread_from_the_published_forum()
    {
        $user = $this->contributor;
        $thread = $this->unpublishedThread;

        Sanctum::actingAs($user);

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $thread->forum->id, 'id' => $thread->id])
        );

        $response->assertNotFound();
    }

    public function test_user_can_view_his_own_unpublished_thread_from_the_published_forum()
    {
        $user = $this->contributor;
        $thread = Thread::factory()
            ->for($user)
            ->for(Forum::first())
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $thread->forum->id, 'id' => $thread->id])
        );

        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_user_can_view_his_own_published_thread_from_the_unpublished_forum()
    {
        $user = $this->contributor;
        $forum = $this->unpublishedForum;
        $thread = Thread::factory()
            ->for($user)
            ->for($forum)
            ->create(['published_at' => null]);

        Sanctum::actingAs($user);

        $response = $this->getJson(
            route('forums.threads.show', ['forumId' => $forum->id, 'id' => $thread->id])
        );

        $response->assertOk()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_member_of_a_published_forum_can_store_thread()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;
        $forum->users()->save($user);
        $thread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertCreated()->assertJsonPath('thread.title', $thread->title);
    }

    public function test_authorized_member_of_a_unpublished_forum_cannot_store_thread()
    {
        $user = $this->contributor;
        $forum = $this->unpublishedForum;
        $forum->users()->save($user);
        $thread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.threads.store', ['forumId' => $forum->id]), [
            'title' => $thread->title,
            'description' => $thread->description,
        ]);

        $response->assertForbidden();
    }

    public function test_unauthorized_member_of_a_published_forum_cannot_store_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->make();
        $forum = $this->publishedForum;
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
        $user = User::factory()->create();
        $forum = $this->publishedForum;
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
        $user = $this->editor;
        $thread = $this->publishedThread;
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
        $user = $this->contributor;
        $thread = $this->publishedThread;
        $updatedThread = Thread::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('threads.update', ['id' => $thread->id]), [
            'title' => $updatedThread->title,
            'description' => $updatedThread->description,
        ]);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_delete_someone_thread()
    {
        $user = $this->editor;
        $thread = $this->publishedThread;

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('threads.destroy', ['id' => $thread->id]));

        $response->assertOk();
    }

    public function test_forum_author_can_delete_someone_thread()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $thread = Thread::factory()
            ->for($forum)
            ->for(User::factory()->create())
            ->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('threads.destroy', ['id' => $thread->id]));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_delete_someone_thread()
    {
        $user = $this->contributor;
        $thread = $this->publishedThread;

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
        $user = $this->editor;

        $response = $this->setPublishedAtStatus($user, 'publish');

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_publish_thread()
    {
        $user = $this->contributor;

        $response = $this->setPublishedAtStatus($user, 'publish');

        $response->assertForbidden();
    }

    public function test_authorized_user_can_unpublish_thread()
    {
        $user = $this->editor;

        $response = $this->setPublishedAtStatus($user, 'unpublish');

        $response->assertOk()
            ->assertJsonPath('thread.publishedAt', null);
    }

    public function test_unauthorized_user_cannot_unpublish_thread()
    {
        $user = $this->contributor;

        $response = $this->setPublishedAtStatus($user, 'unpublish');

        $response->assertForbidden();
    }

    private function setPublishedAtStatus(User $user, string $operation): TestResponse
    {
        $thread = $this->unpublishedThread;

        Sanctum::actingAs($user);

        $response = $this->putJson(route("threads.$operation", ['id' => $thread->id]));

        return $response;
    }
}
