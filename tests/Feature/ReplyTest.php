<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    public function test_visitor_can_view_replies_from_the_published_thread()
    {
        $thread = $this->publishedThread;

        $response = $this->getJson(route('threads.replies.index', ['threadId' => $thread->id]));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_replies_from_the_unpublished_thread()
    {
        $thread = $this->unpublishedThread;

        $response = $this->getJson(route('threads.replies.index', ['threadId' => $thread->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_store_a_reply_in_the_published_thread()
    {
        $user = $this->contributor;
        $thread = $this->publishedThread;
        $reply = Reply::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('threads.replies.store', ['threadId' => $thread->id]), [
            'content' => $reply->content,
        ]);

        $response->assertCreated()
            ->assertJsonPath('reply.content', $reply->content);
    }

    public function test_unauthorized_user_cannot_store_a_reply_in_the_unpublished_thread()
    {
        $user = $this->userWithoutRole;
        $thread = $this->unpublishedThread;
        $reply = Reply::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('threads.replies.store', ['threadId' => $thread->id]), [
            'content' => $reply->content,
        ]);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_update_his_own_reply()
    {
        $user = $this->contributor;
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($user)
            ->for($thread)
            ->create();
        $updatedReply = Reply::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('replies.update', ['id' => $reply->id]), [
            'content' => $updatedReply->content,
        ]);

        $response->assertOk()
            ->assertJsonPath('reply.content', $updatedReply->content);
    }

    public function test_unauthorized_user_cannot_update_someone_reply()
    {
        $user = $this->contributor;
        $secondUser = User::factory()->create();
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($secondUser)
            ->for($thread)
            ->create();
        $updatedReply = Reply::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('replies.update', ['id' => $reply->id]), [
            'content' => $updatedReply->content,
        ]);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_update_someone_reply()
    {
        $user = $this->editor;
        $secondUser = User::factory()->create();
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($secondUser)
            ->for($thread)
            ->create();
        $updatedReply = Reply::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('replies.update', ['id' => $reply->id]), [
            'content' => $updatedReply->content,
        ]);

        $response->assertOk()
            ->assertJsonPath('reply.content', $updatedReply->content);
    }

    public function test_authorized_user_can_delete_his_own_reply()
    {
        $user = $this->contributor;
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($user)
            ->for($thread)
            ->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('replies.destroy', ['id' => $reply->id]));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_delete_someone_reply()
    {
        $user = $this->contributor;
        $secondUser = User::factory()->create();
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($secondUser)
            ->for($thread)
            ->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('replies.destroy', ['id' => $reply->id]));

        $response->assertForbidden();
    }

    public function test_authorized_user_can_delete_someone_reply()
    {
        $user = $this->editor;
        $secondUser = User::factory()->create();
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($secondUser)
            ->for($thread)
            ->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('replies.destroy', ['id' => $reply->id]));

        $response->assertOk();
    }

    public function test_thread_author_can_delete_someone_reply()
    {
        $user = User::has('threads', '>', 0)->first();
        $secondUser = User::factory()->create();
        $thread = $this->publishedThread;
        $reply = Reply::factory()
            ->for($secondUser)
            ->for($thread)
            ->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('replies.destroy', ['id' => $reply->id]));

        $response->assertOk();
    }
}
