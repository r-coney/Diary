<?php
namespace App\DiaryApp\UseCase\Diary\Delete;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;
class Delete implements DeleteInterface
{
    private DiaryRepositoryInterface $diaryRepository;

    public function __construct(DiaryRepositoryInterface $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }

    public function __invoke(Id $id): void
    {
        $diary = $this->diaryRepository->find($id);

        if (is_null($diary)) {
            return;
        }

        $this->diaryRepository->delete($diary);
    }
}
