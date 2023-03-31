<?php
namespace Domain\DiaryApp\Models;

use Domain\DiaryApp\Models\Diary\Diary;

interface DiaryRepository
{
    /**
     * idで検索
     *
     * @param int $id
     * @return Diary
     */
    public function find(int $id): Diary;
}
