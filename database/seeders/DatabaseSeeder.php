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
        Schema::enableForeignKeyConstraints();

        $user = User::factory()->create();

        $replies = Reply::factory()
            ->count(3)
            ->for($user);

        Thread::factory()
            ->count(10)
            ->for($user)
            ->for(Forum::factory()->create())
            ->has($replies)
            ->hasAttached(Tag::factory()->count(3))
            ->create();
    }
}
