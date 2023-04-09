<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

use App\DiaryApp\UseCase\Diary\QueryServiceInterface;
use App\DiaryApp\UseCase\Diary\GetList\GetListInterface;

class GetList implements GetListInterface
{
    private QueryServiceInterface $queryService;

    public function __construct(QueryServiceInterface $queryService)
    {
        $this->queryService = $queryService;
    }

    public function __invoke(GetListCommandInterface $command): array
    {
        // $diaryList = $this->queryService->getAll($command);

        // return $diaryList;

        return [];
    }
}
