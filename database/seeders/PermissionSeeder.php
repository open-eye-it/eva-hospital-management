<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            [
                'name'         => 'category-read',
                'display_name' => 'Read Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'category-create',
                'display_name' => 'create Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'category-update',
                'display_name' => 'update Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'category-status',
                'display_name' => 'status Category',
                'guard_name'   => 'web',
                'section'      => 'category',
            ],
            [
                'name'         => 'user-read',
                'display_name' => 'Read User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'user-create',
                'display_name' => 'Create User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'user-update',
                'display_name' => 'Update User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'user-status',
                'display_name' => 'Status User',
                'guard_name'   => 'web',
                'section'      => 'user',
            ],
            [
                'name'         => 'visiting-fee-read',
                'display_name' => 'Read Visiting Fee',
                'guard_name'   => 'web',
                'section'      => 'visiting-fee',
            ],
            [
                'name'         => 'visiting-fee-update',
                'display_name' => 'Update Visiting Fee',
                'guard_name'   => 'web',
                'section'      => 'visiting-fee',
            ],
            [
                'name'         => 'trainee-read',
                'display_name' => 'Read Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-create',
                'display_name' => 'Create Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-update',
                'display_name' => 'Update Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'trainee-status',
                'display_name' => 'Status Trainee',
                'guard_name'   => 'web',
                'section'      => 'trainee',
            ],
            [
                'name'         => 'room-read',
                'display_name' => 'Read Room',
                'guard_name'   => 'web',
                'section'      => 'room',
            ],
            [
                'name'         => 'room-create',
                'display_name' => 'Create Room',
                'guard_name'   => 'web',
                'section'      => 'room',
            ],
            [
                'name'         => 'room-update',
                'display_name' => 'Update Room',
                'guard_name'   => 'web',
                'section'      => 'room',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
