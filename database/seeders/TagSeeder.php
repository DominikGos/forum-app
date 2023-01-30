<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'name' => 'javascript', 'description' => 'JavaScript is a scripting language for creating dynamic web page content.',
            ],
            [
                'name' => 'python', 'description' => 'Python is an interpreted, object-oriented, high-level programming language with dynamic semantics.',
            ],
            [
                'name' => 'java', 'description' => 'Java is a programming language and computing platform first released by Sun Microsystems in 1995.',
            ],
            [
                'name' => 'c++', 'description' => 'C++ is a general-purpose, object-oriented programming language.',
            ],
            [
                'name' => 'php', 'description' => 'PHP is a server side scripting language that is embedded in HTML. It is used to manage dynamic content, databases, session tracking, even build entire e-commerce sites. ',
            ],
        ]);
    }
}
