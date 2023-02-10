<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()->count(5)->create();

        $users[0]->assignRole('admin');
        $users[1]->assignRole('editor');
        $users[2]->assignRole('contributor');
        $users[3]->assignRole('contributor');
        $users[4]->assignRole('contributor'); 

        $users[0]->update([
            'login' => 'admin',
            'email' => 'admin@mail.com',
            'first_name' => 'admin',
            'last_name' => 'admin'
        ]);

        $users[0]->save();
    }
}
