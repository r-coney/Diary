<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

interface GetListInterface
{
    /**
     * 日記一覧を取得
     * @param GetListCommandInterface $command
     * @return array
     */
    public function __invoke(GetListCommandInterface $command): array;
}
