<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            // Konten Kreator
            ['nama_jabatan' => 'Kepala Divisi Konten Kreator'],
            ['nama_jabatan' => 'Manajer Konten'],
            ['nama_jabatan' => 'Penulis Konten'],
            ['nama_jabatan' => 'Desainer Grafis'],
            ['nama_jabatan' => 'Videografer'],
            ['nama_jabatan' => 'Editor Video'],
            ['nama_jabatan' => 'Spesialis Media Sosial'],

            // Marketing
            ['nama_jabatan' => 'Kepala Divisi Marketing'],
            ['nama_jabatan' => 'Spesialis SEO'],
            ['nama_jabatan' => 'Analis Pemasaran'],
            ['nama_jabatan' => 'Manajer Kampanye Digital'],
            ['nama_jabatan' => 'Spesialis Periklanan'],
            ['nama_jabatan' => 'Manajer Hubungan Pelanggan']
        ];

        foreach ($jabatan as $jab) {
            Jabatan::create($jab);
        }
    }
}
