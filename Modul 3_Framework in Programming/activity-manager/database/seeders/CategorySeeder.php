<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Seminar', 'slug' => 'seminar'],
            ['name' => 'Praktikum', 'slug' => 'praktikum'],
            ['name' => 'Review', 'slug' => 'review'],
            ['name' => 'Presentasi', 'slug' => 'presentasi'],
            ['name' => 'test', 'slug' => 'test'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
