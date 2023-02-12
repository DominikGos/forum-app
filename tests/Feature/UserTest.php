<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_visitor_can_view_user_list()
    {
        $response = $this->getJson(route('users.index'));

        $response->assertOk()
            ->assertJsonStructure(['users']);
    }

    public function test_visitor_can_view_user()
    {
        $user = User::first();
        $response = $this->getJson(route('users.show', ['id' => $user->id]));

        $response->assertOk()
            ->assertJsonPath('user.id', $user->id);
    }

    public function test_visitor_cannot_view_user_that_does_not_exist()
    {
        $response = $this->getJson(route('users.show', ['id' => -100]));

        $response->assertNotFound();
    }

    public function test_user_can_update_own_profile()
    {
        $user = User::role('contributor')->first();
        $updatedUser = User::factory()->make();

        Storage::fake('public');
        Sanctum::actingAs($user);

        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->putJson(route('users.update', ['id' => $user->id]), [
            'first_name' => $updatedUser->first_name,
            'last_name' => $updatedUser->last_name,
            'description' => $updatedUser->description,
            'avatar' => $avatar,
        ]);

        $responseContent = $response->content();
        $responseContent = json_decode($responseContent);

        $response->assertOk()
            ->assertJsonPath('user.firstName', $updatedUser->first_name);

        Storage::disk('public')->assertExists('user/' . $avatar->hashName());
    }

    public function test_user_cannot_update_someone_profile()
    {
        $users = User::role('contributor')->get();
        $user = $users[0];
        $secondUser = $users[1];

        $updatedUser = User::factory()->make();

        Sanctum::actingAs($user);

        $response = $this->putJson(route('users.update', ['id' => $secondUser->id]), [
            'first_name' => $updatedUser->first_name,
            'last_name' => $updatedUser->last_name,
            'description' => $updatedUser->description,
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_delete_own_profile()
    {
        $user = User::role('contributor')->first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('users.destroty', ['id' => $user->id]));

        $response->assertOk();
    }

    public function test_user_cannot_delete_someone_profile()
    {
        $users = User::role('contributor')->get();
        $user = $users[0];
        $secondUser = $users[1];

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('users.destroty', ['id' => $secondUser->id]));

        $response->assertForbidden();
    }

    public function test_authorized_user_can_delete_someone_profile()
    {
        $user = User::role('admin')->first();
        $secondUser = User::role('contributor')->first();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('users.destroty', ['id' => $secondUser->id]));

        $response->assertOk();
    }
}
