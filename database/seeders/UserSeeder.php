<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin =  User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $superadmin->assignRole('Super Admin');

        $contentCreatorJabatan = Jabatan::where('nama_jabatan', 'like', '%Konten%')->pluck('nama_jabatan', 'id')->toArray();
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;
            $email = $faker->unique()->safeEmail;

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('Content Creator');

            $jabatanId = $faker->randomElement(array_keys($contentCreatorJabatan));
            $jabatanNama = $contentCreatorJabatan[$jabatanId];

            Pegawai::create([
                'akun_id' => $user->id,
                'jabatan_id' => $jabatanId,
                'nik' => 'CC' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name,
                'wa' => $faker->phoneNumber,
                'ttl' => $faker->city . ', ' . $faker->date(),
                'alamat' => $faker->address,
                'jenkel' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'foto' => null,
            ]);

            if (strpos(strtolower($jabatanNama), 'kepala divisi') !== false) {
                $user->givePermissionTo('View Sosmed Kadiv Dashboard');
            } else {
                $user->givePermissionTo('View Sosmed Pegawai Dashboard');
            }
        }
    }
}
