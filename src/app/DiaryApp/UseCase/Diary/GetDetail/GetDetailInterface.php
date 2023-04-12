<?php
namespace App\DiaryApp\UseCase\Diary\GetDetail;

use Domain\DiaryApp\Models\Diary\Id;
use App\DiaryApp\UseCase\Diary\GetDetail\DiaryData;

interface GetDetailInterface
{
    public function __invoke(Id $id): DiaryData;
}
