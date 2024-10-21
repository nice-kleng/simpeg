<?php

namespace Database\Seeders;

use App\Models\ReportTikTok;
use App\Models\TimelineTiktok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTikTokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $timelineTikToks = TimelineTiktok::all();

        foreach ($timelineTikToks as $timelineTikTok) {
            ReportTikTok::create([
                'timeline_tiktok_kd' => $timelineTikTok->kd_timeline_tiktok,
                'views' => $faker->numberBetween(1000, 10000),
                'like' => $faker->numberBetween(100, 1000),
                'comment' => $faker->numberBetween(10, 100),
                'share' => $faker->numberBetween(5, 50),
                'save' => $faker->numberBetween(1, 20),
                'usia_18_24' => $faker->numberBetween(100, 1000),
                'usia_25_34' => $faker->numberBetween(100, 1000),
                'usia_35_44' => $faker->numberBetween(100, 1000),
                'usia_45_54' => $faker->numberBetween(100, 1000),
                'gender_pria' => $faker->numberBetween(100, 1000),
                'gender_wanita' => $faker->numberBetween(100, 1000),
                'total_pemutaran' => $faker->numberBetween(1000, 10000),
                'rata_menonton' => $faker->numberBetween(100, 1000),
                'view_utuh' => $faker->numberBetween(100, 1000),
                'pengikut_baru' => $faker->numberBetween(10, 100),
                'link_konten' => $faker->url(),
            ]);
        }
    }
}
