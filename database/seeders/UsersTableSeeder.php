<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin User'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("Admin user created/updated: {$admin->email}");

        // Editor user
        $editor = User::updateOrCreate(
            ['email' => env('EDITOR_EMAIL', 'editor@example.com')],
            [
                'name' => env('EDITOR_NAME', 'Editor User'),
                'password' => Hash::make(env('EDITOR_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("Editor user created/updated: {$editor->email}");
    }
}
