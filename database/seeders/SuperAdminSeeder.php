<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Create Super Admin User
        $userId = DB::table('users')->insertGetId([
            'name'       => 'Super Admin',
            'user_id'    => 'SA-001',
            'email'      => 'superadmin@example.com',
            'password'   => Hash::make('12345678'),
            'role_name'  => 'Admin',
            'status'     => 'Active',
            'join_date'  => now()->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2️⃣ Give ALL permissions
        $permissions = DB::table('permission_lists')->get();

        foreach ($permissions as $permission) {
            DB::table('user_permissions')->insert([
                'user_id'         => $userId,
                'permission_name' => $permission->permission_name,
                'read'            => 'Y',
                'write'           => 'Y',
                'create'          => 'Y',
                'delete'          => 'Y',
                'import'          => 'Y',
                'export'          => 'Y',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
