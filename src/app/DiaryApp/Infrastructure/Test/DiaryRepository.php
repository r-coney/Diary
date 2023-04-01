<?php
namespace App\DiaryApp\Infrastructure\Test;

use DateTime;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;

class DiaryRepository implements DiaryRepositoryInterface
{
    private array $store = [];

    /**
     * 永続化されたDiary配列を取得
     *
     * @return array
     */
    public function store(): array
    {
        return $this->store();
    }

    public function refreshStore(): void
    {
        $this->store = [];
    }

    public function find(Id $id): ?Diary
    {
        foreach ($this->store as $index => $entity) {
            if ($id->value() === $index) {
                return new Diary(
                    new Id($index),
                    new UserId($entity['userId']),
                    new CategoryId($entity['mainCategoryId']),
                    new CategoryId($entity['subCategoryId']),
                    new Title($entity['title']),
                    new Content($entity['content']),
                    new DateTime($entity['createdAt']),
                    isset($entity['updatedAt']) ? new DateTime($entity['updatedAt']) : null
                );
            }
        }

        return null;
    }

    public function findByTitleAndCreatedDate(Title $title, string $date): ?Diary
    {
        foreach ($this->store as $index => $entity) {
            if ($title->value() === $entity['title'] && strpos($entity['createdAt'], $date) !== false) {
                return new Diary(
                    new Id($index),
                    new UserId($entity['userId']),
                    new CategoryId($entity['mainCategoryId']),
                    new CategoryId($entity['subCategoryId']),
                    new Title($entity['title']),
                    new Content($entity['content']),
                    new DateTime($entity['createdAt']),
                    isset($entity['updatedAt']) ? new DateTime($entity['updatedAt']) : null
                );
            }
        }

        return null;
    }

    public function save(Diary $diary): void
    {
        $this->store[$diary->id()] = [
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
