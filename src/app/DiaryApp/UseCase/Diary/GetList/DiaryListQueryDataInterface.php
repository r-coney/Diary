<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

interface DiaryListQueryDataInterface
{
    /**
     * 日記一覧を取得
     * @return array
     */
    public function DiaryList(): array;
}
