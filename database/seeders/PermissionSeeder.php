<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
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

        $editorRole = Role::create(['name' => 'editor']);

        //Contributor can manage his own resources like threads, forums, comments, but can not publish it.
        $contributorRole = Role::create(['name' => 'contributor']);

        //contributor
        $contributorPermissions = [
            Permission::create(['name' => 'create own threads']),
            Permission::create(['name' => 'view own threads']),
            Permission::create(['name' => 'edit own threads']),
            Permission::create(['name' => 'delete own threads']),
        ];

        $contributorRole->syncPermissions($contributorPermissions);

        //editor
        $editorPermissions = [
            Permission::create(['name' => 'view all threads']),
            Permission::create(['name' => 'edit all threads']),
            Permission::create(['name' => 'delete all threads']),
            Permission::create(['name' => 'publish all threads']),
            Permission::create(['name' => 'unpublish all threads']),
            Permission::create(['name' => 'publish all forums']),
            Permission::create(['name' => 'unpublish all forums']),
            Permission::create(['name' => 'create questions and answers']),
            Permission::create(['name' => 'edit questions and answers']),
            Permission::create(['name' => 'delete questions and answers']),
            Permission::create(['name' => 'create all tags']),
            Permission::create(['name' => 'edit all tags']),
            Permission::create(['name' => 'delete all tags']),
        ];

        $editorRole->syncPermissions($contributorPermissions);
        $editorRole->syncPermissions($editorPermissions);

        //admin
        $adminPermissions = [
            Permission::create(['name' => 'create users']),
            Permission::create(['name' => 'delete all users']),
            Permission::create(['name' => 'change user roles']),
            Permission::create(['name' => 'add editors']),
            Permission::create(['name' => 'delete editors']),
        ];

        $adminRole->syncPermissions($contributorPermissions);
        $adminRole->syncPermissions($editorPermissions);
        $adminRole->syncPermissions($adminPermissions);
    }
}
