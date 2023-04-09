<?php
namespace App\DiaryApp\UseCase\Diary;

use Illuminate\Database\Eloquent\Collection;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

interface QueryServiceInterface
{
    /**
     * 日記一覧を取得
     * @param GetListCommandInterface $command
     * @return Collection
     */
    public function getAll(GetListCommandInterface $command): Collection;
}