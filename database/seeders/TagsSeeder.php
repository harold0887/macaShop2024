<?php

namespace Database\Seeders;

use App\Models\Tag;
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

        Tag::create([
            'name' => 'participacion valiosa',
            'icon' => 'star_rate',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Tag::create([
            'name' => 'mood',
            'icon' => 'mood',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Tag::create([
            'name' => 'sunny',
            'icon' => 'sunny',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Tag::create([
            'name' => 'medication',
            'icon' => 'medication',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Tag::create([
            'name' => 'dentistry',
            'icon' => 'dentistry',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Tag::create([
            'name' => 'face_2',
            'icon' => 'face_2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
