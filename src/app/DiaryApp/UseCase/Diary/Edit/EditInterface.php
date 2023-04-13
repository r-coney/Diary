<?php
namespace App\DiaryApp\UseCase\Diary\Edit;

use App\DiaryApp\UseCase\Diary\Edit\UpdateCommandInterface;

interface EditInterface
{
    /**
     * 日記を編集
     *
     * @param UpdateCommandInterface $command
     * @return void
     */
    public function __invoke(UpdateCommandInterface $command): void;
}
