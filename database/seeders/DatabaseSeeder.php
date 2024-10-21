<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            JabatanSeeder::class,
            ProductSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            TimelineInstagramSeeder::class,
            ReportTimelineInstagramSeeder::class,
            ReportTikTokLiveSeeder::class,
            TimelineTikTokSeeder::class,
            ReportTikTokSeeder::class,
        ]);
    }
}
