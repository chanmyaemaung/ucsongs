<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find roles first
        $adminRole = Role::where('name', 'Admin')->first();
        $editorRole = Role::where('name', 'Editor')->first();

        if (!$adminRole || !$editorRole) {
            $this->command->warn('Roles not found. Make sure to run RolesTableSeeder first.');
            return;
        }

        // Try to find admin user by email from .env
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminUser = User::where('email', $adminEmail)->first();

        // Find editor user by email from .env
        $editorEmail = env('EDITOR_EMAIL', 'editor@example.com');
        $editorUser = User::where('email', $editorEmail)->first();

        // If specific users not found, try to assign to first and second users
        if (!$adminUser || !$editorUser) {
            $users = User::take(2)->get();

            if (count($users) > 0 && !$adminUser) {
                $adminUser = $users[0];
                $this->command->info("Assigned Admin role to user: {$adminUser->email}");
            }

            if (count($users) > 1 && !$editorUser) {
                $editorUser = $users[1];
                $this->command->info("Assigned Editor role to user: {$editorUser->email}");
            }
        }

        // Assign roles to users if both user and role exist
        if ($adminUser && $adminRole) {
            $adminUser->roles()->sync($adminRole->id);
            $this->command->info("Admin role assigned to {$adminUser->email}");
        } else {
            $this->command->warn('Admin user not found or could not be assigned role.');
        }

        if ($editorUser && $editorRole) {
            $editorUser->roles()->sync($editorRole->id);
            $this->command->info("Editor role assigned to {$editorUser->email}");
        } else {
            $this->command->warn('Editor user not found or could not be assigned role.');
        }
    }
}
