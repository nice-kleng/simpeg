<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MitraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode' => 'M' . fake()->unique()->numberBetween(1000, 9999),
            'nama' => fake()->name(),
            'status_mitra' => fake()->randomElement(['active', 'inactive']),
            'kota_wilayah' => fake()->city(),
            'fb' => fake()->userName(),
            'ig' => fake()->userName(),
            'marketplace' => fake()->randomElement(['Shopee', 'Tokopedia', 'Lazada']),
            'no_hp' => fake()->phoneNumber(),
            'upline' => null,
            'bulan' => fake()->monthName(),
            'note_1' => fake()->sentence(),
            'note_2' => fake()->sentence(),
            'tanggal' => fake()->date(),
        ];
    }
}
