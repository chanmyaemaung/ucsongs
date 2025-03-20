<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permission permissions
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'view users',
            'view roles',
            'view permissions',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view users',
        ]);

        // Create admin user
        $adminUser = User::create([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
        $adminUser->assignRole('admin');

        // Create editor user
        $editorUser = User::create([
            'name' => env('EDITOR_NAME'),
            'email' => env('EDITOR_EMAIL'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('EDITOR_PASSWORD')),
        ]);
        $editorUser->assignRole('editor');

        // Create normal user
        $user = User::create([
            'name' => env('USER_NAME'),
            'email' => env('USER_EMAIL'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('USER_PASSWORD')),
        ]);
        $user->assignRole('user');
    }
}
