<?php
namespace App\DiaryApp\Infrastructure\InMemory;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;

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

    public function find(int $id): ?Diary
    {
        foreach ($this->store as $index => $entity) {
            if ($id === $index) {
                return new Diary(
                    new Id($index),
                    new UserId($entity['userId']),
                    new CategoryId($entity['mainCategoryId']),
                    new CategoryId($entity['subCategoryId']),
                    new Title($entity['title']),
                    new Content($entity['content']),
                    $entity['createdAt'],
                    $entity['updatedAt']
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
