<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

interface GetListInterface
{
    /**
     * 日記一覧を取得
     * @param GetListCommandInterface $command
     * @return DiaryListQueryData
     */
    public function __invoke(GetListCommandInterface $command): DiaryListQueryData;
}
