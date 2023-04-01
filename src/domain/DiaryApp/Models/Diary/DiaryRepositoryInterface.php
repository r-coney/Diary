<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\Diary\Diary;

interface DiaryRepositoryInterface
{
    /**
     * idで検索
     *
     * @param int $id
     * @return Diary
     */
    public function find(int $id): Diary;

    /**
     * Diaryエンティティを永続化
     *
     * @param Diary $diary
     * @return void
     */
    public function save(Diary $diary): void;
}
