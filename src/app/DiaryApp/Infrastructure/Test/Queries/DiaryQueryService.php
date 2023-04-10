<?php
namespace App\DiaryApp\Infrastructure\Test\Queries;

use Domain\DiaryApp\Models\Diary\Diary;
use Illuminate\Database\Eloquent\Collection;
use App\DiaryApp\UseCase\Diary\QueryServiceInterface;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

class DiaryQueryService implements QueryServiceInterface
{
    private array $store = [];

    /**
     * 格納されているデータを取得
     *
     * @return Collection
     */
    public function store(): array
    {
        return $this->store;
    }

    /**
     * データを格納
     *
     * @param Diary $diary
     * @return void
     */
    public function add(Diary $diary): void
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

    public function getAll(GetListCommandInterface $command): DiaryListQueryData
    {
        return new DiaryListQueryData($this->store);
    }
}