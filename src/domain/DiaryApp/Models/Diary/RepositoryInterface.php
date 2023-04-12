<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;

interface RepositoryInterface
{
    /**
     * idで検索
     * @param Id $id
     * @return Diary|null
     */
    public function find(Id $id): ?Diary;

    /**
     * titleと登録日付で検索
     *
     * @param Title $title
     * @param string $date
     * @return Diary|null
     */
    public function findByTitleAndCreatedDate(Title $title, string $date): ?Diary;

    /**
     * Diaryエンティティを永続化
     *
     * @param Diary $diary
     * @return void
     */
    public function save(Diary $diary): void;
}
