<?php

namespace Tests\Feature;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ForumTest extends TestCase
{
    public function test_visitor_can_view_published_forums()
    {
        $response = $this->getJson(route('forums.index'));

        $response->assertOk();
    }

    public function test_visitor_cannot_view_unpublished_forums()
    {
        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_authorized_user_can_view_unpublished_forums()
    {
        $user = $this->editor;

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_view_unpublished_forums()
    {
        $user = $this->contributor;

        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_user_can_view_his_own_unpublished_forums()
    {
        $user = $this->contributor;
        $forum = Forum::factory()
            ->for($user)
            ->create(['published_at' => null, 'name' => 'original forum name']);

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonFragment(['name' => $forum->name]);
    }

    public function test_visitor_can_view_published_forum()
    {
        $forum = $this->publishedForum;

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.name', $forum->name);
    }

    public function test_visitor_cannot_view_unpublished_forum()
    {
        $forum = $this->unpublishedForum;
        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_forum()
    {
        $user = $this->editor;
        $forum = $this->unpublishedForum;

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.name', $forum->name);
    }

    public function test_unauthorized_user_cannot_view_unpublished_forum()
    {
        $user = $this->contributor;
        $forum = $this->unpublishedForum;

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertNotFound();
    }

    public function test_user_can_view_his_own_unpublished_forum()
    {
        $user = $this->contributor;

        Sanctum::actingAs($user);

        $forum = Forum::factory()
            ->for($user)
            ->create(['published_at' => null]);

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.name', $forum->name);
    }

    public function test_authorized_user_can_store_forum()
    {
        $user = $this->contributor;
        $forum = Forum::factory()->make(['name' => 'updated forum name']);

        Sanctum::actingAs($user);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('file.jpg');

        $response = $this->postJson(route('forums.store'), [
            'name' => $forum->name,
            'description' => $forum->description,
            'image' => $file,
        ]);

        $response->assertCreated()
            ->assertJsonPath('forum.name', $forum->name);

        Storage::disk('public')->assertExists('/forum/' . $file->hashName());
    }

    public function test_unauthorized_user_cannot_store_forum()
    {
        $user = $this->userWithoutRole;
        $forum = Forum::factory()->make(['name' => 'updated forum name']);

        Sanctum::actingAs($user);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('file.jpg');

        $response = $this->postJson(route('forums.store'), [
            'name' => $forum->name,
            'description' => $forum->description,
            'image' => $file,
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_update_own_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $updatedForumName = 'updated forum name';

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.update', ['id' => $forum->id]), [
            'name' => $updatedForumName,
        ]);

        $response->assertOk()
            ->assertJsonPath('forum.name', $updatedForumName);
    }

    public function test_authorized_user_can_update_someone_forum()
    {
        $user = $this->editor;
        $forum = $this->publishedForum;
        $updatedForumName = 'updated forum name';

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.update', ['id' => $forum->id]), [
            'name' => $updatedForumName,
        ]);

        $response->assertOk()
            ->assertJsonPath('forum.name', $updatedForumName);
    }

    public function test_unauthorized_user_cannot_update_someone_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;
        $updatedForumName = 'updated forum name';

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.update', ['id' => $forum->id]), [
            'name' => $updatedForumName,
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_delete_own_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.destroy', ['id' => $forum->id]));

        $response->assertOk();
    }

    public function test_authorized_user_can_delete_someone_forum()
    {
        $user = $this->editor;
        $forum = $this->publishedForum;

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.destroy', ['id' => $forum->id]));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_delete_someone_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.destroy', ['id' => $forum->id]));

        $response->assertForbidden();
    }

    public function test_authorized_user_can_publish_forum()
    {
        $user = $this->editor;
        $forum = $this->unpublishedForum;

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.publish', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_publish_forum()
    {
        $user = $this->contributor;
        $forum = $this->unpublishedForum;

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.publish', ['id' => $forum->id]));

        $response->assertForbidden();
    }

    public function test_authorized_user_can_unpublish_forum()
    {
        $user = $this->editor;
        $forum = $this->publishedForum;

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.unpublish', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.publishedAt', null);
    }

    public function test_unauthorized_user_cannot_unpublish_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.unpublish', ['id' => $forum->id]));

        $response->assertForbidden();
    }

    public function test_forum_author_can_add_a_user_to_the_published_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $forum->published_at = now();
        $forum->save();
        $futureForumMember = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.users.store', [
            'forumId' => $forum->id, 'id' => $futureForumMember->id,
        ]));

        $response->assertCreated();
    }

    public function test_forum_author_cannot_add_a_user_to_the_unpublished_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $forum->published_at = null;
        $forum->save();
        $futureForumMember = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.users.store', [
            'forumId' => $forum->id, 'id' => $futureForumMember->id,
        ]));

        $response->assertForbidden();
    }

    public function test_forum_author_can_remove_a_user_from_the_published_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $forum->published_at = now();
        $forum->save();
        $forumMember = User::factory()->create();
        $forum->users()->save($forumMember);

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.users.destroy', [
            'forumId' => $forum->id, 'id' => $forumMember->id,
        ]));

        $response->assertOk();
    }

    public function test_forum_author_cannot_remove_a_user_from_the_unpublished_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $forum->published_at = null;
        $forum->save();
        $forumMember = User::factory()->create();
        $forum->users()->save($forumMember);

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.users.destroy', [
            'forumId' => $forum->id, 'id' => $forumMember->id,
        ]));

        $response->assertForbidden();
    }

    public function test_unauthorized_user_cannot_add_a_user_to_the_published_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;
        $futureForumMember = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('forums.users.store', [
            'forumId' => $forum->id, 'id' => $futureForumMember->id,
        ]));

        $response->assertForbidden();
    }

    public function test_unauthorized_user_cannot_remove_a_user_from_the_published_forum()
    {
        $user = $this->contributor;
        $forum = $this->publishedForum;
        $forumMember = User::factory()->create();
        $forum->users()->save($forumMember);

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.users.destroy', [
            'forumId' => $forum->id, 'id' => $forumMember->id,
        ]));

        $response->assertForbidden();
    }
}
