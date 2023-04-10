<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

use App\DiaryApp\UseCase\Diary\QueryServiceInterface;
use App\DiaryApp\UseCase\Diary\GetList\GetListInterface;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

class GetList implements GetListInterface
{
    private QueryServiceInterface $queryService;

    public function __construct(QueryServiceInterface $queryService)
    {
        $this->queryService = $queryService;
    }

    public function __invoke(GetListCommandInterface $command): DiaryListQueryData
    {
        return $this->queryService->getAll($command);
    }
}
