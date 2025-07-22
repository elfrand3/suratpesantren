<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::table('users')->truncate();

        User::factory()->createMany([[
                'name' => 'Admin',
                'no_telp' => '08123456789',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Admin'
            ],[
                'name' => 'Pengasuh',
                'no_telp' => '08123456780',
                'email' => 'pengasuh@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Pengasuh'
            ]
        ]);
    }
}
