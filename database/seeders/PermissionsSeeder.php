<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Admin can do everything.
        $adminRole = Role::create(['name' => 'admin']);

        //Admin forum can manage all user resources like threads, comments, publish threads of users. His rights apply to a specific forum
        $forumAdminRole = Role::create(['name' => 'forum admin']);

        //Author can manage his own resources like threads, forums, comments, but can not publish it.
        $authorRole = Role::create(['name' => 'author']);

        //author
        Permission::create(['name' => 'create own threads']);
        Permission::create(['name' => 'view own threads']);
        Permission::create(['name' => 'edit own threads']);
        Permission::create(['name' => 'delete own threads']);

        $authorRole->givePermissionTo('create own threads');
        $authorRole->givePermissionTo('view own threads');
        $authorRole->givePermissionTo('edit own threads');
        $authorRole->givePermissionTo('delete own threads');

        //forum admin
        Permission::create(['name' => 'publish forum threads']);
        Permission::create(['name' => 'unpublish forum threads']);
        Permission::create(['name' => 'view forum threads']);
        Permission::create(['name' => 'edit forum threads']);
        Permission::create(['name' => 'delete forum threads']);
        Permission::create(['name' => 'add forum admins']);
        Permission::create(['name' => 'delete forum admins']);

        $forumAdminRole->givePermissionTo('publish forum threads');
        $forumAdminRole->givePermissionTo('unpublish forum threads');
        $forumAdminRole->givePermissionTo('view forum threads');
        $forumAdminRole->givePermissionTo('edit forum threads');
        $forumAdminRole->givePermissionTo('delete forum threads');
        $forumAdminRole->givePermissionTo('add forum admins');
        $forumAdminRole->givePermissionTo('delete forum admins');

        //admin
        Permission::create(['name' => 'publish all threads']);
        Permission::create(['name' => 'unpublish all threads']);
        Permission::create(['name' => 'publish all forums']);
        Permission::create(['name' => 'unpublish all forums']);
        Permission::create(['name' => 'create questions and answers']);
        Permission::create(['name' => 'edit questions and answers']);
        Permission::create(['name' => 'delete questions and answers']);
        Permission::create(['name' => 'create tags']);
        Permission::create(['name' => 'update tags']);
        Permission::create(['name' => 'delete tags']);
        Permission::create(['name' => 'view all threads']);
        Permission::create(['name' => 'edit all threads']);
        Permission::create(['name' => 'destroy all threads']);
        Permission::create(['name' => 'add admins']);
        Permission::create(['name' => 'delete admins']);

        $adminRole->givePermissionTo('view all threads');
        $adminRole->givePermissionTo('edit all threads');
        $adminRole->givePermissionTo('destroy all threads');
        $adminRole->givePermissionTo('publish all threads');
        $adminRole->givePermissionTo('unpublish all threads');
        $adminRole->givePermissionTo('publish all forums');
        $adminRole->givePermissionTo('unpublish all forums');
        $adminRole->givePermissionTo('create questions and answers');
        $adminRole->givePermissionTo('edit questions and answers');
        $adminRole->givePermissionTo('delete questions and answers');
        $adminRole->givePermissionTo('create tags');
        $adminRole->givePermissionTo('update tags');
        $adminRole->givePermissionTo('delete tags');
        $adminRole->givePermissionTo('add admins');
        $adminRole->givePermissionTo('delete admins');
    }
}
