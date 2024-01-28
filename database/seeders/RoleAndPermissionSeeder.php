<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = array();

        // Misc
        $permissions[] = Permission::create(['name' => 'N/A']);

        // Permission MODEL
        $permissions[] = Permission::create(['name' => 'viewAny: Permission']);
        $permissions[] = Permission::create(['name' => 'view: Permission']);
        $permissions[] = Permission::create(['name' => 'create: Permission']);
        $permissions[] = Permission::create(['name' => 'update: Permission']);
        $permissions[] = Permission::create(['name' => 'delete: Permission']);
        $permissions[] = Permission::create(['name' => 'restore: Permission']);
        $permissions[] = Permission::create(['name' => 'forceDelete: Permission']);

        // Role MODEL
        $permissions[] = Permission::create(['name' => 'viewAny: Role']);
        $permissions[] = Permission::create(['name' => 'view: Role']);
        $permissions[] = Permission::create(['name' => 'create: Role']);
        $permissions[] = Permission::create(['name' => 'update: Role']);
        $permissions[] = Permission::create(['name' => 'delete: Role']);
        $permissions[] = Permission::create(['name' => 'restore: Role']);
        $permissions[] = Permission::create(['name' => 'forceDelete: Role']);

        // User MODEL
        $permissions[] = Permission::create(['name' => 'viewAny: User']);
        $permissions[] = Permission::create(['name' => 'view: User']);
        $permissions[] = Permission::create(['name' => 'create: User']);
        $permissions[] = Permission::create(['name' => 'update: User']);
        $permissions[] = Permission::create(['name' => 'delete: User']);
        $permissions[] = Permission::create(['name' => 'restore: User']);
        $permissions[] = Permission::create(['name' => 'forceDelete: User']);

        // CREATE ROLES
        $userRole = Role::create(['name' => 'user'])->syncPermissions([
            $permissions[0],
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin'])
            ->syncPermissions($permissions);

        // CREATE ADMINS & USERS
        User::create([
            'name' => 'super admin',
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($superAdminRole);

        User::create([
            'name' => 'user',
            'email' => 'user@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($userRole);
    }
}
