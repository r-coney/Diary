<?php
namespace App\DiaryApp\UseCase\Diary\Edit;

use App\DiaryApp\UseCase\Diary\Edit\EditCommandInterface;

class EditCommand implements EditCommandInterface
{
    private $diaryId;
    private $title;
    private $content;
    private $mainCategoryId;
    private $subCategoryId;

    public function __construct(
        int $diaryId,
        string $title,
        ?string $content,
        int $mainCategoryId,
        ?int $subCategoryId
    ) {
        $this->diaryId = $diaryId;
        $this->title = $title;
        $this->content = $content;
        $this->mainCategoryId = $mainCategoryId;
        $this->subCategoryId = $subCategoryId;
    }

    public function diaryId(): int
    {
        return $this->diaryId;
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

    public function hasSubCategoryId(): bool
    {
        return !is_null($this->subCategoryId);
    }
}
