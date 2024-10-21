<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimelineInstagram;
use App\Models\User;
use Faker\Factory as Faker;

class TimelineInstagramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $contentCreators = User::role('Content Creator')->get();
        $jenisProject = ['FEED', 'STORY'];
        $status = ['On Going', 'Desain', 'Editing Revisi', 'Approve', 'Upload', 'Syuting Done', 'Storyboard'];
        $format = ['Single Image', 'Carrousel', 'Reels', 'Video', 'Video & Image', 'Motion Graphic'];
        $jenisKonten = ['Educate', 'Inspire', 'Entertain', 'Convience', 'Testimonial'];
        $products = Product::all();
        for ($i = 0; $i < 20; $i++) {
            $timeline = TimelineInstagram::create([
                'kd_timelineig' => 'TL' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'tanggal' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'jenis_project' => $faker->randomElement($jenisProject),
                'status' => $faker->randomElement($status),
                'format' => $faker->randomElement($format),
                'jenis_konten' => $faker->randomElement($jenisKonten),
                'produk' => $faker->randomElement($products->pluck('nama_product')),
                'head_term' => $faker->sentence(2),
                'core_topic' => $faker->sentence(3),
                'subtopic' => $faker->sentence(4),
                'copywriting' => $faker->paragraph,
                'notes' => $faker->optional()->sentence,
                'refrensi' => $faker->optional()->url,
            ]);

            $picCount = $faker->numberBetween(1, 3);
            $pics = $contentCreators->random($picCount);
            $timeline->pics()->attach($pics);
        }
    }
}
