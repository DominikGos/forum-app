<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Forum;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('forums')->truncate();
        DB::table('replies')->truncate();
        DB::table('tags')->truncate();
        DB::table('threads')->truncate();
        DB::table('thread_tag')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $this->call([
            PermissionsSeeder::class,
            TagSeeder::class
        ]);

        $admin = User::factory([
            'login' => 'admin',
            'email' => 'admin@mail.com',
            'first_name' => 'admin',
            'last_name' => 'admin'
        ])->create();
        $admin->assignRole('admin');
        $admin->assignRole('forum admin');
        $admin->assignRole('author');

        $user = User::factory()->create();
        $tags = Tag::all();
        $forum = Forum::factory()->for($user)->create();
        $replies = Reply::factory()->for($user)->count(2);
        $threads = Thread::factory()
            ->count(3)
            ->hasAttached($tags)
            ->for($user)
            ->for($forum)
            ->has($replies)
            ->create();
    }
}
