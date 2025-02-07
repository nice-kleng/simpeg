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

        // $jabatan = [14, 15, 16];
        // for ($i = 0; $i < 4; $i++) {
        //     $name = fake('id_ID')->name;
        //     $email = fake('id_ID')->unique()->safeEmail;
        //     $user = User::create([
        //         'name' => $name,
        //         'email' => $email,
        //         'password' => Hash::make('password'),
        //     ]);

        //     $user->assignRole('CRM');

        //     Pegawai::create([
        //         'akun_id' => $user->id,
        //         'jabatan_id' => fake()->randomElement($jabatan),
        //         'nik' => fake('id_ID')->nik,
        //         'nama' => $name,
        //         'wa' => fake()->phoneNumber,
        //         'ttl' => fake()->city . ', ' . fake()->date(),
        //         'alamat' => fake()->address,
        //         'jenkel' => fake()->randomElement(['Laki-laki', 'Perempuan']),
        //         'foto' => null,
        //     ]);
        // }

        // $contentCreatorJabatan = Jabatan::where('nama_jabatan', 'like', '%Konten%')->pluck('nama_jabatan', 'id')->toArray();
        // $marketingJabatan = Jabatan::whereIn('nama_jabatan', [
        //     'Kepala Divisi Marketing',
        //     'Spesialis SEO',
        //     'Analis Pemasaran',
        //     'Manajer Kampanye Digital',
        //     'Spesialis Periklanan',
        //     'Manajer Hubungan Pelanggan'
        // ])->pluck('nama_jabatan', 'id')->toArray();

        // $faker = Faker::create('id_ID');

        // Create Content Creator users
        // for ($i = 0; $i < 10; $i++) {
        //     $name = $faker->name;
        //     $email = $faker->unique()->safeEmail;

        //     $user = User::create([
        //         'name' => $name,
        //         'email' => $email,
        //         'password' => Hash::make('password'),
        //     ]);

        //     $user->assignRole('Content Creator');

        //     $jabatanId = $faker->randomElement(array_keys($contentCreatorJabatan));
        //     $jabatanNama = $contentCreatorJabatan[$jabatanId];

        //     Pegawai::create([
        //         'akun_id' => $user->id,
        //         'jabatan_id' => $jabatanId,
        //         'nik' => 'CC' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
        //         'nama' => $name,
        //         'wa' => $faker->phoneNumber,
        //         'ttl' => $faker->city . ', ' . $faker->date(),
        //         'alamat' => $faker->address,
        //         'jenkel' => $faker->randomElement(['Laki-laki', 'Perempuan']),
        //         'foto' => null,
        //     ]);

        //     if (strpos(strtolower($jabatanNama), 'kepala divisi') !== false) {
        //         $user->givePermissionTo('View Sosmed Kadiv Dashboard');
        //     } else {
        //         $user->givePermissionTo('View Sosmed Pegawai Dashboard');
        //     }
        // }

        // Create Marketing users
        // for ($i = 0; $i < 10; $i++) {
        //     $name = $faker->name;
        //     $email = $faker->unique()->safeEmail;

        //     $user = User::create([
        //         'name' => $name,
        //         'email' => $email,
        //         'password' => Hash::make('password'),
        //     ]);

        //     $user->assignRole('Marketing');

        //     if (strpos(strtolower($jabatanNama), 'kepala divisi') !== false) {
        //         $user->givePermissionTo('View Marketing Kadiv Dashboard');
        //     } else {
        //         $user->givePermissionTo('View Marketing Pegawai Dashboard');
        //     }

        //     $jabatanId = $faker->randomElement(array_keys($marketingJabatan));
        //     $jabatanNama = $marketingJabatan[$jabatanId];

        //     Pegawai::create([
        //         'akun_id' => $user->id,
        //         'jabatan_id' => $jabatanId,
        //         'nik' => 'MK' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
        //         'nama' => $name,
        //         'wa' => $faker->phoneNumber,
        //         'ttl' => $faker->city . ', ' . $faker->date(),
        //         'alamat' => $faker->address,
        //         'jenkel' => $faker->randomElement(['Laki-laki', 'Perempuan']),
        //         'foto' => null,
        //     ]);
        // }

        // $marketingKadiv = User::create([
        //     'name' => 'Marketing Kadiv',
        //     'email' => 'marketingkadiv@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);

        // $marketingKadiv->assignRole('Marketing');
        // $marketingKadiv->givePermissionTo('View Marketing Kadiv Dashboard');

        // $staffMarketing = User::create([
        //     'name' => 'Staff Marketing',
        //     'email' => 'staffmarketing@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);

        // $staffMarketing->assignRole('Marketing');
        // $staffMarketing->givePermissionTo('View Marketing Pegawai Dashboard');
    }
}
