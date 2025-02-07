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
            [
                'name' => 'Marketing',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CRM',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($role);

        // Generate permissions
        // Artisan::call('permissions:generate');

        $permissions = [
            [
                'name' => 'View Superadmin Dashboard',
                'guard_name' => 'web',
                'group' => 'dashboard',
            ],
            [
                'name' => 'View Sosmed Kadiv Dashboard',
                'guard_name' => 'web',
                'group' => 'dashboard',
            ],
            [
                'name' => 'View Sosmed Pegawai Dashboard',
                'guard_name' => 'web',
                'group' => 'dashboard',
            ],
            [
                'name' => 'View Marketing Kadiv Dashboard',
                'guard_name' => 'web',
                'group' => 'dashboard',
            ],
            [
                'name' => 'View Marketing Pegawai Dashboard',
                'guard_name' => 'web',
                'group' => 'dashboard',
            ],
            [
                'name' => 'View CRM Dashboard',
                'guard_name' => 'web',
                'group' => 'dashboard',
            ],
            [
                'name' => 'View Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Create Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Edit Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Delete Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Create Report Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Edit Report Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Export Timeline Instagram',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'View Timeline TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Create Timeline TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Edit Timeline TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Delete Timeline TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Create Report TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Edit Report TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Delete Report TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Detail Report TikTok',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'View Report TikTok Live',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Create Report TikTok Live',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Edit Report TikTok Live',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Delete Report TikTok Live',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Export Report TikTok Live',
                'guard_name' => 'web',
                'group' => 'sosmed',
            ],
            [
                'name' => 'Follow Up Leads',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'View Leads',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Create Leads',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Edit Leads',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Delete Leads',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Follow Up Brand',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'View Brand',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Create Brand',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Edit Brand',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Delete Brand',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Follow Up Turlap',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'View Turlap',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Create Turlap',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Edit Turlap',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Delete Turlap',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'View Sumber Marketing',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Create Sumber Marketing',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Edit Sumber Marketing',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'Delete Sumber Marketing',
                'guard_name' => 'web',
                'group' => 'marketing',
            ],
            [
                'name' => 'View Pertanyaan',
                'guard_name' => 'web',
                'group' => 'crm',
            ],
            [
                'name' => 'View Jadwal Kunjungan',
                'guard_name' => 'web',
                'group' => 'crm',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // $superAdmin = Role::where('name', 'Super Admin')->first();
        // $contentCreator = Role::where('name', 'Content Creator')->first();
        // $marketing = Role::where('name', 'Marketing')->first();

        // $contentCreator->givePermissionTo([
        //     'View Timeline Instagram',
        //     'Create Timeline Instagram',
        //     'Edit Timeline Instagram',
        //     'Delete Timeline Instagram',
        //     'Create Report Timeline Instagram',
        //     'Edit Report Timeline Instagram',
        //     'Export Timeline Instagram',
        //     'View Timeline TikTok',
        //     'Create Timeline TikTok',
        //     'Edit Timeline TikTok',
        //     'Create Report TikTok',
        //     'Edit Report TikTok',
        //     'Delete Report TikTok',
        //     'Detail Report TikTok',
        //     'Delete Timeline TikTok',
        //     'View Report TikTok Live',
        //     'Create Report TikTok Live',
        //     'Edit Report TikTok Live',
        //     'Delete Report TikTok Live',
        //     'Export Report TikTok Live',
        // ]);

        // $marketing->givePermissionTo([
        //     'Follow Up Leads',
        //     'View Leads',
        //     'Create Leads',
        //     'Edit Leads',
        //     'Delete Leads',
        //     'Follow Up Brand',
        //     'View Brand',
        //     'Create Brand',
        //     'Edit Brand',
        //     'Delete Brand',
        //     'Follow Up Turlap',
        //     'View Turlap',
        //     'Create Turlap',
        //     'Edit Turlap',
        //     'Delete Turlap',
        //     'View Sumber Marketing',
        //     'Create Sumber Marketing',
        //     'Edit Sumber Marketing',
        //     'Delete Sumber Marketing',
        // ]);
    }
}
