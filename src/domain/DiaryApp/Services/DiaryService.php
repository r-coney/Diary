<?php
namespace Domain\DiaryApp\Services;

use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;

class DiaryService
{
    private DiaryRepositoryInterface $diaryRepository;

    public function __construct(
        DiaryRepositoryInterface $diaryRepository
    ) {
        $this->diaryRepository = $diaryRepository;
    }

    /**
     * DiaryがDBにすでに存在するか検証
     *
     * @param Diary $diary
     * @return bool
     */
    public function exists(Diary $diary): bool
    {
        $found = $this->diaryRepository->findByTitleAndCreatedDate(
            new Title($diary->title()),
            $diary->createdDate()
        );

        return $found !== null;
    }
}
