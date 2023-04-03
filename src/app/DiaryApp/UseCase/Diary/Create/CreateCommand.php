<?php
namespace App\DiaryApp\UseCase\Diary\Create;

use App\DiaryApp\UseCase\Diary\Create\CreateCommandInterface;

class CreateCommand implements CreateCommandInterface
{
    private int $userId;
    private string $title;
    private ?string $content;
    private int $mainCategoryId;
    private ?int $subCategoryId;

    public function __construct(
        int $userId,
        string $title,
        ?string $content,
        int $mainCategoryId,
        ?int $subCategoryId,
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->mainCategoryId = $mainCategoryId;
        $this->subCategoryId = $subCategoryId;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function mainCategoryId(): int
    {
        return $this->mainCategoryId;
    }

    public function subCategoryId(): ?int
    {
        return $this->subCategoryId;
    }
}
