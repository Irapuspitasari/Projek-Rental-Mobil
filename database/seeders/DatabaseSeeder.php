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
                'nama' => 'Toyota',
                'slug' => 'toyota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Honda',
                'slug' => 'honda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Daihatsu',
                'slug' => 'daihatsu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Suzuki',
                'slug' => 'suzuki',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Mitsubishi',
                'slug' => 'mitsubishi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Nissan',
                'slug' => 'nissan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hyundai',
                'slug' => 'hyundai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Wuling',
                'slug' => 'wuling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('brands')->insert($brands);

        $types = [
            [
                'nama' => 'MPV',
                'slug' => 'mpv',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'SUV',
                'slug' => 'suv',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sedan',
                'slug' => 'sedan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hatchback',
                'slug' => 'hatchback',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Minibus',
                'slug' => 'minibus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'City Car',
                'slug' => 'city-car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Double Cabin',
                'slug' => 'double-cabin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('types')->insert($types);
    }
}
