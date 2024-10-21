<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimelineInstagram;
use App\Models\ReportTimelineInstagram;

class ReportTimelineInstagramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $timelineInstagrams = TimelineInstagram::all();

        foreach ($timelineInstagrams as $timelineInstagram) {
            ReportTimelineInstagram::create([
                'timeline_instagram_kd' => $timelineInstagram->kd_timelineig,
                'jangkauan' => $faker->numberBetween(1000, 10000),
                'interaksi' => $faker->numberBetween(100, 1000),
                'aktivitas' => $faker->numberBetween(50, 500),
                'impresi' => $faker->numberBetween(2000, 20000),
                'like' => $faker->numberBetween(50, 500),
                'comment' => $faker->numberBetween(10, 100),
                'share' => $faker->numberBetween(5, 50),
                'save' => $faker->numberBetween(1, 20),
                'pengikut' => $faker->numberBetween(500, 5000),
                // 'pengikut_baru' => $faker->numberBetween(10, 100),
                'bukan_pengikut' => $faker->numberBetween(100, 1000),
                'profile' => $faker->numberBetween(10, 100),
                'beranda' => $faker->numberBetween(500, 5000),
                'jelajahi' => $faker->numberBetween(100, 1000),
                'lainnya' => $faker->numberBetween(10, 100),
                'tagar' => $faker->numberBetween(1, 50),
                'jumlah_pemutaran' => $faker->numberBetween(1000, 10000),
                'waktu_tonton' => $faker->time(),
                'rata' => $faker->randomFloat(2, 1, 5),
                'link_konten' => $faker->url,
            ]);
        }
    }
}
