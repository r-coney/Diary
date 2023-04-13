<?php

namespace Database\Seeders\InMemory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use stdClass;

class CategoriesSeeder extends Seeder
{
    private int $currentId;

    public function __construct()
    {
        $this->currentId = 0;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cache::put('categories', [
            $this->createCategory('work'),
            $this->createCategory('life'),
            $this->createCategory('study'),
        ]);
    }

    /**
     * カテゴリーを作成
     *
     * @param string $name
     * @return stdClass
     */
    private function createCategory(string $name): stdClass
    {
        $this->currentId++;
        $category = new stdClass();
        $category->id = $this->currentId;
        $category->name = $name;
        $category->createdAt = date('Y-m-d H:i:s');

        return $category;
    }
}
