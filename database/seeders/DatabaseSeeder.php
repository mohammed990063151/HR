<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
         $this->call([
            PermissionListSeeder::class,
            SuperAdminSeeder::class,
        ]);

//         User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);
        $user = User::create([
    'name' => 'Admin Full',
    'email' => 'admin@enala.sa',
    'password' => Hash::make('enala0063151'),
    'role_name' => 'Admin', // أو Super Admin حسب عندك
]);
    }
}
