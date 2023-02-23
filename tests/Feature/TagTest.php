<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function test_visitor_can_view_all_tags()
    {
        $response = $this->getJson(route('tags.index'));

        $response->assertOk();
    }

    public function test_authorized_user_can_store_tag()
    {
        $user = $this->editor;
        $tag = Tag::factory()->make(['name' => 'original tag name']);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('tags.store'), [
            'name' => $tag->name,
            'description' => $tag->description,
        ]);

        $response->assertCreated()
            ->assertJsonPath('tag.name', $tag->name);
    }

    public function test_unauthorized_user_cannot_store_tag()
    {
        $user = $this->contributor;
        $tag = Tag::factory()->make(['name' => 'original tag name']);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('tags.store'), [
            'name' => $tag->name,
            'description' => $tag->description,
        ]);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_update_tag()
    {
        $user = $this->editor;
        $tag = Tag::first();
        $updatedTag = Tag::factory()->make(['name' => 'original tag name']);

        Sanctum::actingAs($user);

        $response = $this->putJson(route('tags.update', ['id' => $tag->id]), [
            'name' => $updatedTag->name,
            'description' => $updatedTag->description,
        ]);

        $response->assertOk()
            ->assertJsonPath('tag.name', $updatedTag->name);
    }

    public function test_unauthorized_user_cannot_update_tag()
    {
        $user = $this->contributor;
        $tag = Tag::first();
        $updatedTag = Tag::factory()->make(['name' => 'original tag name']);

        Sanctum::actingAs($user);

        $response = $this->putJson(route('tags.update', ['id' => $tag->id]), [
            'name' => $updatedTag->name,
            'description' => $updatedTag->description,
        ]);

        $response->assertForbidden();
    }

    public function test_authorized_user_can_delete_tag()
    {
        $user = $this->editor;
        $tag = Tag::first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('tags.destroy', ['id' => $tag->id]));

        $response->assertOk();
    }

    public function test_unauthorized_user_cannot_delete_tag()
    {
        $user = $this->contributor;
        $tag = Tag::first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('tags.destroy', ['id' => $tag->id]));

        $response->assertForbidden();
    }
}
