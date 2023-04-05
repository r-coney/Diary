<?php
namespace App\DiaryApp\UseCase\Diary\Create;

use App\DiaryApp\UseCase\Diary\Create\CreateCommand;

interface CreateInterface
{
    public function __invoke(CreateCommand $createCommand): void;
}
