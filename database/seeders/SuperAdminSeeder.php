<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('12345678'),
            ]
        );

        // web role
        $webRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ]);

        // api role
        $apiRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'api',
        ]);

        $user->assignRole($webRole);
        $user->assignRole($apiRole);
    }
}
