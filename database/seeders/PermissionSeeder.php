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

        $adminRole = Role::create(['name' => 'admin']);

        $editorRole = Role::create(['name' => 'editor']);

        $contributorRole = Role::create(['name' => 'contributor']);

        $contributorPermissions = [
            Permission::create(['name' => 'create own threads']),
            Permission::create(['name' => 'view own threads']),
            Permission::create(['name' => 'edit own threads']),
            Permission::create(['name' => 'delete own threads']),
            Permission::create(['name' => 'create own forums']),
            Permission::create(['name' => 'view own forums']),
            Permission::create(['name' => 'edit own forums']),
            Permission::create(['name' => 'delete own forums']),
            Permission::create(['name' => 'add users to own forum']),
            Permission::create(['name' => 'remove users from own forum']),
        ];

        $contributorRole->syncPermissions($contributorPermissions);

        $editorPermissions = [
            Permission::create(['name' => 'view all threads']),
            Permission::create(['name' => 'edit all threads']),
            Permission::create(['name' => 'delete all threads']),
            Permission::create(['name' => 'publish all threads']),
            Permission::create(['name' => 'unpublish all threads']),
            Permission::create(['name' => 'view all forums']),
            Permission::create(['name' => 'edit all forums']),
            Permission::create(['name' => 'delete all forums']),
            Permission::create(['name' => 'publish all forums']),
            Permission::create(['name' => 'unpublish all forums']),
            Permission::create(['name' => 'create questions and answers']),
            Permission::create(['name' => 'edit questions and answers']),
            Permission::create(['name' => 'delete questions and answers']),
            Permission::create(['name' => 'create all tags']),
            Permission::create(['name' => 'edit all tags']),
            Permission::create(['name' => 'delete all tags']),
            Permission::create(['name' => 'add users to all forums']),
            Permission::create(['name' => 'remove users from all forums']),
        ];

        $editorRole->syncPermissions($contributorPermissions);
        $editorRole->syncPermissions($editorPermissions);

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
