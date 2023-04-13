<?php

namespace Database\Seeders\InMemory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class Reset extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cache::forget('categories');
    }
}
