<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Umam',
            'email' => 'umam@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('Password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $brands = [
            [
                'name' => 'Toyota',
                'slug' => 'toyota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Honda',
                'slug' => 'honda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Daihatsu',
                'slug' => 'daihatsu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Suzuki',
                'slug' => 'suzuki',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mitsubishi',
                'slug' => 'mitsubishi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nissan',
                'slug' => 'nissan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hyundai',
                'slug' => 'hyundai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wuling',
                'slug' => 'wuling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('brands')->insert($brands);

        $types = [
            [
                'name' => 'MPV',
                'slug' => 'mpv',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SUV',
                'slug' => 'suv',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sedan',
                'slug' => 'sedan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hatchback',
                'slug' => 'hatchback',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minibus',
                'slug' => 'minibus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'City Car',
                'slug' => 'city-car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Double Cabin',
                'slug' => 'double-cabin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('types')->insert($types);
    }
}
