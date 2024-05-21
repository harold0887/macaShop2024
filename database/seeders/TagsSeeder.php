<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert(
            [
                'name' => 'star_rate',
                'icon' => 'star_rate',
                'created_at' => now(),
                'updated_at' => now()

            ],
            [
                'name' => 'mood',
                'icon' => 'mood',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'sunny',
                'icon' => 'sunny',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'medication',
                'icon' => 'medication',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'face_2',
                'icon' => 'face_2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'dentistry',
                'icon' => 'dentistry',
                'created_at' => now(),
                'updated_at' => now()
            ]


        );
    }
}
