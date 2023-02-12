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
use PhpParser\Node\Stmt\For_;

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
            PermissionSeeder::class,
            UserSeeder::class,
            TagSeeder::class
        ]);

        $users = User::all();
        $author = $users[4];
        $tags = Tag::all();

        $publishedForum = Forum::factory()
            ->for($author)
            ->create(['published_at' => now()]);
        $unpublishedForum = Forum::factory()
            ->for($author)
            ->create(['published_at' => null]);

        $replies = Reply::factory()->for($author)->count(2);

        $unpublishedThread = Thread::factory()
            ->for($author)
            ->for($publishedForum)
            ->create(['published_at' => null]);
        $publishedThread = Thread::factory()
            ->for($author)
            ->for($publishedForum)
            ->create(['published_at' => now()]);
        }
}
