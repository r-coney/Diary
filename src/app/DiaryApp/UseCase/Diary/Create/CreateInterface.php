<?php
namespace App\DiaryApp\UseCase\Diary\Create;

use App\DiaryApp\UseCase\Diary\Create\CreateCommandInterface;

interface CreateInterface
{
    public function __invoke(CreateCommandInterface $createCommand): void;
}
