<?php

namespace Database\Seeders;

use App\Modules\Users\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::create([
           'name' => 'KingKronos',
           'email' => 'Kronosneverdies4@',
            'password' => 'Kronosneverdies4@',
           'permission_level' => 2,
        ]);
    }
}
