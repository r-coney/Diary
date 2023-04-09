<?php
namespace App\DiaryApp\Infrastructure\InMemory\Queries;

use Illuminate\Database\Eloquent\Collection;
use App\DiaryApp\UseCase\Diary\QueryServiceInterface;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

class DiaryQueryService implements QueryServiceInterface
{
    public function getAll(GetListCommandInterface $command): Collection
    {
        return collect();
    }
}
