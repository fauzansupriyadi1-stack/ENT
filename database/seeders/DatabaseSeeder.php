<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\HeroSlot;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@fznnews.com'],
            [
                'name' => 'Fauzan Admin',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
                'avatar' => null,
                'bio' => 'Super admin & Chief Editor FZN NEWS.',
            ]
        );

        // 2. Create Categories
        $categoriesData = [
            ['name' => 'National',    'slug' => 'national',   'color' => '#1c4424'],
            ['name' => 'Ekonomi',     'slug' => 'ekonomi',    'color' => '#2e6b3c'],
            ['name' => 'Tekno',       'slug' => 'tekno',      'color' => '#429b57'],
            ['name' => 'Olahraga',    'slug' => 'olahraga',   'color' => '#62c47a'],
            ['name' => 'Hiburan',     'slug' => 'hiburan',    'color' => '#8fe0a2'],
            ['name' => 'Gaya Hidup',  'slug' => 'gaya-hidup', 'color' => '#c2f3cc'],
        ];

        foreach ($categoriesData as $c) {
            Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // 3. Initialize Clean Hero Slots (FOTO_1 to FOTO_8)
        for ($i = 1; $i <= 8; $i++) {
            HeroSlot::firstOrCreate(
                ['slot_code' => "FOTO_{$i}"],
                [
                    'article_id' => null,
                    'override_title' => null,
                    'is_manual' => false,
                ]
            );
        }
    }
}
