<?php

namespace Database\Seeders;

use App\Models\TimelineTiktok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimelineTikTokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $users = \App\Models\User::role('Content Creator')->get();
        $products = \App\Models\Product::all();

        for ($i = 0; $i < 20; $i++) {
            $report = TimelineTiktok::create([
                // 'kd_timeline_tiktok' => 'TT' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now'),
                'tipe_konten' => $faker->randomElement(['Reels', 'Other']),
                'jenis_konten' => $faker->randomElement(['Educate', 'Inspire', 'Entertain', 'Convience', 'Testimonial', 'Commercial']),
                'produk' => $faker->randomElement($products->pluck('nama_product')),
                'hook_konten' => $faker->sentence,
                'copywriting' => $faker->paragraph,
                'jam_upload' => $faker->time('H:i'),
            ]);

            $picCount = $faker->numberBetween(1, 3);
            $pics = $users->random($picCount);
            $report->pics()->attach($pics);
        }
    }
}
