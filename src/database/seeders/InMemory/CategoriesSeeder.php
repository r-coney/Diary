<?php

namespace Database\Seeders\InMemory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cache::put('categories', [
            [
                'id' => 1,
                'name' => 'work',
            ],
            [
                'id' => 2,
                'name' => 'life',
            ],
            [
                'id' => 3,
                'name' => 'hobby',
            ],
        ]);
    }
}
