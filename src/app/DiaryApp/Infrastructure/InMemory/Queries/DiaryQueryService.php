<?php
namespace App\DiaryApp\Infrastructure\InMemory\Queries;

use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\QueryServiceInterface;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;

class DiaryQueryService implements QueryServiceInterface
{
    private DiaryRepositoryInterface $diaryRepository;

    public function __construct(
        DiaryRepositoryInterface $diaryRepository,
    ) {
        $this->diaryRepository = $diaryRepository;
    }

    public function getAll(GetListCommandInterface $command): DiaryListQueryData
    {
        return new DiaryListQueryData($this->diaryRepository->store());
    }
}
