<?php
namespace App\DiaryApp\UseCase\Diary\Edit;

use App\DiaryApp\UseCase\Diary\Edit\EditCommandInterface;
interface EditInterface
{
    /**
     * 日記を編集
     *@param  EditCommandInterface $command
     * @return void
     */
    public function __invoke(EditCommandInterface $command): void;
}
