<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Content Creator',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($role);

        // Generate permissions
        Artisan::call('permissions:generate');

        // $permission = [
        //     [
        //         'name' => 'View Jabatan',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Jabatan',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Jabatan',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Jabatan',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'View Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Report Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Report Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Export Timeline Instagram',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'View Product',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Product',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Product',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Product',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'View Mitra',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Mitra',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Mitra',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Mitra',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'View Pegawai',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Pegawai',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Pegawai',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Pegawai',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'View Report TikTok',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Report TikTok',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Report TikTok',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Report TikTok',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'View Report TikTok Live',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Create Report TikTok Live',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Edit Report TikTok Live',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Delete Report TikTok Live',
        //         'guard_name' => 'web',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ];
        // Permission::insert($permission);

        // $superAdmin = Role::where('name', 'Super Admin')->first();
        $contentCreator = Role::where('name', 'Content Creator')->first();

        // $superAdmin->givePermissionTo([
        //     'View Jabatan',
        //     'Create Jabatan',
        //     'Edit Jabatan',
        //     'Delete Jabatan',
        //     'View Timeline Instagram',
        //     'Create Timeline Instagram',
        //     'Edit Timeline Instagram',
        //     'Delete Timeline Instagram',
        //     'View Product',
        //     'Create Product',
        //     'Edit Product',
        //     'Delete Product',
        //     'View Pegawai',
        //     'Create Pegawai',
        //     'Edit Pegawai',
        //     'Delete Pegawai',
        //     'View Mitra',
        //     'Create Mitra',
        //     'Edit Mitra',
        //     'Delete Mitra',
        //     'View Report TikTok',
        //     'Create Report TikTok',
        //     'Edit Report TikTok',
        //     'Delete Report TikTok',
        //     'View Report TikTok Live',
        //     'Create Report TikTok Live',
        //     'Edit Report TikTok Live',
        //     'Delete Report TikTok Live',
        //     'Create Report Timeline Instagram',
        //     'Edit Report Timeline Instagram',
        // ]);

        $contentCreator->givePermissionTo([
            'View Timeline Instagram',
            'Create Timeline Instagram',
            'Edit Timeline Instagram',
            'Delete Timeline Instagram',
            'Create Report Timeline Instagram',
            'Edit Report Timeline Instagram',
            'Export Timeline Instagram',
            'View Timeline TikTok',
            'Create Timeline TikTok',
            'Edit Timeline TikTok',
            'Create Report TikTok',
            'Edit Report TikTok',
            'Delete Report TikTok',
            'Detail Report TikTok',
            'Delete Timeline TikTok',
            'View Report TikTok Live',
            'Create Report TikTok Live',
            'Edit Report TikTok Live',
            'Delete Report TikTok Live',
            'Export Report TikTok Live',
        ]);
    }
}
