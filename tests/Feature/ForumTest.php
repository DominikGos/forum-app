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
    use RefreshDatabase;

    protected $seed = true;

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
        $user = User::role('editor')->first();

        Sanctum::actingAs($user);

        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonFragment(['publishedAt' => null]);
    }

    public function test_unauthorized_user_cannot_view_unpublished_forums()
    {
        $user = User::role('contributor')->first();

        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonMissingExact(['publishedAt' => null]);
    }

    public function test_author_can_view_his_own_unpublished_forums()
    {
        $user = User::role('contributor')->first();
        $unpublishedForum = Forum::factory()
            ->for($user)
            ->create(['published_at' => null]);

        $response = $this->getJson(route('forums.index'));

        $response->assertOk()
            ->assertJsonFragment(['name' => $unpublishedForum->name]);
    }

    public function test_visitor_can_view_published_forum()
    {
        $forum = Forum::where('published_at', '!=', null)->first();

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.name', $forum->name);
    }

    public function test_visitor_cannot_view_unpublished_forum()
    {
        $forum = Forum::where('published_at', null)->first();

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertNotFound();
    }

    public function test_authorized_user_can_view_unpublished_forum()
    {
        $user = User::role('editor')->first();

        Sanctum::actingAs($user);

        $forum = Forum::where('published_at', null)->first();

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.name', $forum->name);
    }

    public function test_unauthorized_user_cannot_view_unpublished_forum()
    {
        $user = User::role('contributor')->first();

        Sanctum::actingAs($user);

        $forum = Forum::where('published_at', null)->first();

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertNotFound();
    }

    public function test_author_can_view_his_own_unpublished_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();

        Sanctum::actingAs($user);

        $forum = Forum::where('published_at', null)->first();

        $response = $this->getJson(route('forums.show', ['id' => $forum->id]));

        $response->assertOk()
            ->assertJsonPath('forum.name', $forum->name);
    }

    public function test_authorized_user_can_store_forum()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::factory()->make(['name' => 'original forum name']);

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
        $user = User::factory()->create();
        $forum = Forum::factory()->make(['name' => 'original forum name']);

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

    public function test_authorized_user_can_update_someone_forum()
    {
        $user = User::role('editor')->first();
        $forum = Forum::first();
        $updatedForumName = 'original forum name';

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.update', ['id' => $forum->id]), [
            'name' => $updatedForumName,
        ]);

        $response->assertOk()
            ->assertJsonPath('forum.name', $updatedForumName);
    }

    public function test_unauthorized_user_cannot_update_someone_forum()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::first();
        $updatedForumName = 'original forum name';

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.update', ['id' => $forum->id]), [
            'name' => $updatedForumName,
        ]);

        $response->assertForbidden();
    }

    public function test_author_can_update_own_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();
        $updatedForumName = 'original forum name';

        Sanctum::actingAs($user);

        $response = $this->putJson(route('forums.update', ['id' => $forum->id]), [
            'name' => $updatedForumName,
        ]);

        $response->assertOk()
            ->assertJsonPath('forum.name', $updatedForumName);
    }

    public function test_authorized_user_can_delete_someone_forum()
    {
        $user = User::role('editor')->first();
        $forum = Forum::first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.destroy', ['id' => $forum->id]));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_delete_someone_forum()
    {
        $user = User::role('contributor')->first();
        $forum = Forum::first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.destroy', ['id' => $forum->id]));

        $response->assertForbidden();
    }

    public function test_author_can_delete_own_forum()
    {
        $user = User::has('createdForums', '>', 0)->first();
        $forum = $user->createdForums()->first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('forums.destroy', ['id' => $forum->id]));

        $response->assertOk();
    }
}
