<?php
namespace App\DiaryApp\UseCase\Diary\GetDetail;

use Domain\DiaryApp\Models\Diary\Id;
use App\Exceptions\DiaryApp\Diary\UseCase\DiaryNotFoundException;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;

class GetDetail
{
    private DiaryRepositoryInterface $diaryRepository;

    public function __construct(DiaryRepositoryInterface $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }

    public function __invoke(Id $id): DiaryData
    {
        $diary = $this->diaryRepository->find($id);

        if (is_null($diary)) {
            throw new DiaryNotFoundException('日記が見つかりませんでした。');
        }

        return new DiaryData($diary);
    }
}
