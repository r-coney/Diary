<?php
namespace App\DiaryApp\UseCase\Diary\Delete;

use Domain\DiaryApp\Models\Diary\Id;

interface DeleteInterface
{
    /**
     * 日記を削除
     *
     * @param Id $id
     */
    public function __invoke(Id $id): void;
}
