<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permission_create',
            'permission_edit',
            'permission_delete',
            'permission_show',
            'permission_access',
            'role_create',
            'role_edit',
            'role_delete',
            'role_show',
            'role_access',
            'user_create',
            'user_edit',
            'user_delete',
            'user_show',
            'user_access',
            'song_create',
            'song_edit',
            'song_delete',
            'song_show',
            'song_access',
            'song_author_create',
            'song_author_edit',
            'song_author_delete',
            'song_author_show',
            'song_author_access',
            'song_composer_create',
            'song_composer_edit',
            'song_composer_delete',
            'song_composer_show',
            'song_composer_access',
            'song_year_create',
            'song_year_edit',
            'song_year_delete',
            'song_year_show',
            'song_year_access',
            'family_pledge_create',
            'family_pledge_edit',
            'family_pledge_delete',
            'family_pledge_show',
            'family_pledge_access',
            'family_pledge_item_create',
            'family_pledge_item_edit',
            'family_pledge_item_delete',
            'family_pledge_item_show',
            'family_pledge_item_access',
            'ebook_create',
            'ebook_edit',
            'ebook_delete',
            'ebook_show',
            'ebook_access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
