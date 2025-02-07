<?php

namespace Database\Seeders;

use App\Models\Mitra;
use Illuminate\Database\Seeder;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 main mitra (without upline)
        $mainMitras = Mitra::factory(5)->create();

        // Create 3 downlines for each main mitra
        foreach ($mainMitras as $mitra) {
            Mitra::factory(3)->create([
                'upline' => $mitra->id
            ]);
        }
    }
}
