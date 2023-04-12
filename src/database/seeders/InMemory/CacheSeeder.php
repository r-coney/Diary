<?php

namespace Database\Seeders\InMemory;

use Illuminate\Database\Seeder;
use Database\Seeders\InMemory\Reset;
use Database\Seeders\InMemory\CategoriesSeeder;

class CacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            Reset::class,
            CategoriesSeeder::class,
        ]);
    }
}
