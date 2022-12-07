<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Schedules;
use App\Models\Topics;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $collections = [
            [
                'id' => 1,
                'name' => 'admin',
            ],
            [
                'id' => 2,
                'name' => 'dekan',
            ],
            [
                'id' => 3,
                'name' => 'psikolog'
            ],
            [
                'id' => 4,
                'name' => 'user',
            ]
        ];

        foreach ($collections as $item) {
            User::create([
                'name' => $item['name'],
                'full_name' => $item['name'],
                'email' => strtolower(str_replace(' ', '_', $item['name'])) . '@app.com',
                'password' => bcrypt('password'),
                'role_id' => $item['id'],
            ]);
        }

        News::factory(20)->create();
        Topics::factory(10)->create();
        Schedules::factory(10)->create();
    }
}
