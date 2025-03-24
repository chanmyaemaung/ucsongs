<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permissions = Permission::all();
        $this->command->info("Found " . $admin_permissions->count() . " permissions for admin role");

        // Get all "access", "show", and "edit" permissions except user, role, and permission management
        $editor_permissions = Permission::where(function ($query) {
            $query->where('name', 'LIKE', '%_access')
                ->orWhere('name', 'LIKE', '%_show')
                ->orWhere('name', 'LIKE', '%_create')
                ->orWhere('name', 'LIKE', '%_edit')
                ->orWhere('name', 'LIKE', '%_delete');
        })->whereNotIn('name', [
            // Exclude user management
            'user_access',
            'user_show',
            'user_edit',
            'user_create',
            'user_delete',

            // Exclude role management
            'role_access',
            'role_show',
            'role_edit',
            'role_create',
            'role_delete',

            // Exclude permission management
            'permission_access',
            'permission_show',
            'permission_edit',
            'permission_create',
            'permission_delete',
        ])->get();
        $this->command->info("Found " . $editor_permissions->count() . " permissions for editor role");

        // Create roles if they don't exist yet
        $adminRole = Role::where('name', 'Admin')->first();
        $editorRole = Role::where('name', 'Editor')->first();

        if (!$adminRole) {
            $this->command->warn("Admin role not found. Make sure to run RolesTableSeeder first.");
        }

        if (!$editorRole) {
            $this->command->warn("Editor role not found. Make sure to run RolesTableSeeder first.");
        }

        if ($adminRole) {
            $adminRole->permissions()->sync($admin_permissions);
            $this->command->info("Admin role permissions synced successfully");
        }

        if ($editorRole) {
            $editorRole->permissions()->sync($editor_permissions);
            $this->command->info("Editor role permissions synced successfully");
        }
    }
}
