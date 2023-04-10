<?php
namespace App\DiaryApp\UseCase\Diary;

use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

interface QueryServiceInterface
{
    /**
     * 日記一覧を取得
     * @param GetListCommandInterface $command
     * @return DiaryListQueryData
     */
    public function getAll(GetListCommandInterface $command): DiaryListQueryData;
}