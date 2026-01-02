<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Super Admin', 'deskripsi' => 'Super Administrator'],
            ['name' => 'Admin', 'deskripsi' => 'Admin'],
            ['name' => 'user', 'deskripsi' => 'User'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
