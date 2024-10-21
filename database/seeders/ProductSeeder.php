<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $kosmetikTypes = [
            'Lipstick',
            'Foundation',
            'Mascara',
            'Eyeshadow',
            'Blush',
            'Concealer',
            'Eyeliner',
            'Bronzer',
            'Highlighter',
            'Primer',
            'Setting Spray',
            'Nail Polish',
            'Lip Gloss',
            'BB Cream',
            'CC Cream',
            'Brow Pencil',
            'Face Mask',
            'Toner',
            'Serum',
            'Moisturizer'
        ];

        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'kd_product' => 'KSM' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama_product' => $faker->randomElement($kosmetikTypes) . ' ' . $faker->word,
                'stock' => $faker->numberBetween(10, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
