<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Belal Hasan',
                'password' => bcrypt('123456'),
            ]
        );

        $role = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web']
        );

        // all permissions
        $permissions = Permission::where('guard_name', 'web')->get();

        // role -> permissions
        $role->syncPermissions($permissions);

        // user ->role
        if (! $user->hasRole('Admin')) {
            $user->assignRole('Admin');
        }
    }
}
