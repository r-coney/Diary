<?php
namespace App\DiaryApp\UseCase\Diary\Create;

use DateTime;
use Illuminate\Support\Facades\DB;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Services\DiaryService;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use App\DiaryApp\UseCase\Diary\Create\CreateInterface;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;
use App\DiaryApp\UseCase\Diary\Create\CreateCommandInterface;
use App\Exceptions\DiaryApp\Diary\CanNotCreateDiaryException;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;

class Create implements CreateInterface
{
    private DiaryFactoryInterface $diaryFactory;
    private DiaryService $diaryService;
    private DiaryRepositoryInterface $diaryRepository;

    public function __construct(
        DiaryFactoryInterface $diaryFactory,
        DiaryService $diaryService,
        DiaryRepositoryInterface $diaryRepository
    ) {
        $this->diaryFactory = $diaryFactory;
        $this->diaryService = $diaryService;
        $this->diaryRepository = $diaryRepository;
    }

    public function __invoke(CreateCommandInterface $createCommand): void
    {
        DB::transaction(function () use ($createCommand) {
            $subCategoryId = $createCommand->subCategoryId();
            $content = $createCommand->content();

            $diary = $this->diaryFactory->create(
                new UserId($createCommand->userId()),
                new CategoryId($createCommand->mainCategoryId()),
                isset($subCategoryId) ? new CategoryId($subCategoryId) : null,
                new Title($createCommand->title()),
                isset($content) ? new Content($content) : null,
                new DateTime(),
            );

            if ($this->diaryService->exists($diary)) {
                throw new CanNotCreateDiaryException('日記は既に存在しています。');
            }

            $this->diaryRepository->save($diary);
        });
    }
}
