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
        Schema::enableForeignKeyConstraints();

        $this->call([
            TagSeeder::class
        ]);

        $tags = Tag::all();

        $user = User::factory()->create();

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
