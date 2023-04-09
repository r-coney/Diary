<?php
namespace App\DiaryApp\UseCase\Diary;

use Illuminate\Database\Eloquent\Collection;

interface QueryServiceInterface
{
    /**
     * 日記一覧を取得
     * @param GetListCommand $command
     * @return Collection
     */
    public function getList(GetListCommand $command): Collection;
}