<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTikTokLiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $users = \App\Models\User::role('Content Creator')->get();

        for ($i = 0; $i < 20; $i++) {
            $report = \App\Models\ReportTikTokLive::create([
                'kd_report_tiktok_live' => 'RTL' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now'),
                'judul' => $faker->sentence,
                'waktu_mulai' => $faker->time(),
                'durasi' => $faker->time('H:i:s', '04:00:00'),
                'total_tayangan' => $faker->numberBetween(500, 5000),
                'penonton_unik' => $faker->numberBetween(100, 1000),
                'rata_menonton' => $faker->time('i:s'),
                'jumlah_penonton_teratas' => $faker->numberBetween(50, 500),
                'pengikut' => $faker->numberBetween(100, 1000),
                'penonton_lainnya' => $faker->numberBetween(50, 500),
                'pengikut_baru' => $faker->numberBetween(10, 500),
                'penonton_berkomentar' => $faker->numberBetween(50, 500),
                'suka' => $faker->numberBetween(1000, 100000),
                'berbagi' => $faker->numberBetween(10, 1000),
            ]);

            $picCount = $faker->numberBetween(1, 3);
            $pics = $users->random($picCount);
            $report->pics()->attach($pics);
        }
    }
}
