<?php
namespace App\DiaryApp\Infrastructure\InMemory\Repositories;

use DateTime;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;
use stdClass;

class DiaryRepository implements DiaryRepositoryInterface
{
    private DiaryFactoryInterface $dairyFactory;
    private array $store;

    public function __construct(
        DiaryFactoryInterface $dairyFactory
    ) {
        $this->dairyFactory = $dairyFactory;
        $this->store = Cache::get('diaries', []);
    }

    /**
     * 永続化されたDiary配列を取得
     *
     * @return array
     */
    public function store(): array
    {
        $this->store = Cache::get('diaries', []);

        return $this->store;
    }

    public function find(Id $id): ?Diary
    {
        foreach ($this->store() as $entity) {
            if ($id->value() === $entity->id) {
                return $this->dairyFactory->create(
                    new UserId($entity->userId),
                    new CategoryId($entity->mainCategoryId),
                    new CategoryId($entity->subCategoryId),
                    new Title($entity->title),
                    new Content($entity->content),
                    new DateTime($entity->createdAt),
                    isset($entity->updatedAt) ? new DateTime($entity->updatedAt) : null,
                    new Id($entity->id),
                );
            }
        }

        return null;
    }

    public function findByTitleAndCreatedDate(Title $title, string $date): ?Diary
    {
        foreach ($this->store() as $entity) {
            if ($title->value() === $entity->title && strpos($entity->createdAt, $date) !== false) {
                return $this->dairyFactory->create(
                    new UserId($entity->userId),
                    new CategoryId($entity->mainCategoryId),
                    new CategoryId($entity->subCategoryId),
                    new Title($entity->title),
                    new Content($entity->content),
                    new DateTime($entity->createdAt),
                    isset($entity->updatedAt) ? new DateTime($entity->updatedAt) : null,
                    new Id($entity->id),
                );
            }
        }

        return null;
    }

    public function save(Diary $diary): void
    {
        $diaryData = new stdClass();
        $diaryData->id = $diary->id();
        $diaryData->userId = $diary->userId();
        $diaryData->mainCategoryId = $diary->mainCategoryId();
        $diaryData->subCategoryId = $diary->subCategoryId();
        $diaryData->title = $diary->title();
        $diaryData->content = $diary->content();
        $diaryData->createdAt = $diary->createdAt();
        $diaryData->updatedAt = $diary->updatedAt();

        $store = $this->store();
        $store[] = $diaryData;
        Cache::put('diaries', $store);
    }
}
