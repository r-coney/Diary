<?php
namespace App\DiaryApp\Infrastructure\Test\Repositories;

use DateTime;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;

class DiaryRepository implements DiaryRepositoryInterface
{
    private DiaryFactoryInterface $dairyFactory;
    private array $store = [];

    public function __construct(
        DiaryFactoryInterface $dairyFactory
    ) {
        $this->dairyFactory = $dairyFactory;
    }

    /**
     * 永続化されたDiary配列を取得
     *
     * @return array
     */
    public function store(): array
    {
        return $this->store;
    }

    public function refreshStore(): void
    {
        $this->store = [];
    }

    public function find(Id $id): ?Diary
    {
        foreach ($this->store as $entity) {
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
        foreach ($this->store as $index => $entity) {
            if ($title->value() === $entity->title && strpos($entity->createdAt, $date) !== false) {
                return $this->dairyFactory->create(
                    new UserId($entity->userId),
                    new CategoryId($entity->mainCategoryId),
                    new CategoryId($entity->subCategoryId),
                    new Title($entity->title),
                    new Content($entity->content),
                    new DateTime($entity->createdAt),
                    isset($entity->updatedAt) ? new DateTime($entity->updatedAt) : null,
                    new Id($index),
                );
            }
        }

        return null;
    }

    public function save(Diary $diary): void
    {
        foreach ($this->store as $index => $entity) {
            if ($diary->id() === $entity->id) {
                unset($this->store[$index]);
            }
        }

        $this->store[] = (object) [
            'id' => $diary->id(),
            'userId' => $diary->userId(),
            'mainCategoryId' => $diary->mainCategoryId(),
            'subCategoryId' => $diary->subCategoryId(),
            'title' => $diary->title(),
            'content' => $diary->content(),
            'createdAt' => $diary->createdAt(),
            'updatedAt' => $diary->updatedAt()
        ];
    }
}
