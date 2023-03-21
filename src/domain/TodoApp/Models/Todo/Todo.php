<?php
namespace Domain\TodoApp\Models\Todo;

class Todo
{
    private int $id;
    private int $userId;
    private int $mainCategoryId;
    private int $subCategoryId;
    private string $title;
    private ?string $content;
    private int $status;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        int $userId,
        int $mainCategoryId,
        int $subCategoryId,
        string $title,
        ?string $content,
        int $status,
        string $createdAt,
        string $updatedAt
    ) {
        $this->userId = $userId;
        $this->mainCategoryId = $mainCategoryId;
        $this->subCategoryId = $subCategoryId;
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function mainCategoryId(): int
    {
        return $this->mainCategoryId;
    }

    public function subCategoryId(): int
    {
        return $this->subCategoryId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }
}
