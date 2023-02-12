<?php

namespace Tests\Feature;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->assertJsonFragment(['name' => $forum->name]);
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
            ->assertJsonFragment(['name' => $forum->name]);
    }

    public function test_unauthorized_user_can_view_unpublished_forum()
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
            ->assertJsonFragment(['name' => $forum->name]);
    }
}
