<?php
namespace Domain\DiaryApp\Models\Diary;

use DateTime;
use Domain\DiaryApp\Exceptions\Category\InvalidIdException as InvalidCategoryIdException;
use Domain\DiaryApp\Exceptions\Diary\InvalidIdException;
use Domain\DiaryApp\Exceptions\Diary\InvalidTitleException;
use Domain\DiaryApp\Exceptions\User\InvalidIdException as InvalidUserIdException;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Entity;

class Diary implements Entity
{
    private Id $id;
    private UserId $userId;
    private CategoryId $mainCategoryId;
    private ?CategoryId $subCategoryId;
    private Title $title;
    private ?Content $content;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(
        Id $id,
        UserId $userId,
        CategoryId $mainCategoryId,
        ?CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        DateTime $createdAt,
        ?DateTime $updatedAt = null
    ) {
        if (is_null($id)) {
            throw new InvalidIdException('Diary IDが存在しません');
        }

        if (is_null($userId)) {
            throw new InvalidUserIdException('User IDが存在しません');
        }

        if (is_null($mainCategoryId)) {
            throw new InvalidCategoryIdException('Main Category IDが存在しません');
        }

        if ($mainCategoryId->equals($subCategoryId)) {
            throw new InvalidCategoryIdException('CategoryはMainとSubで同一のものは指定できません');
        }

        if (is_null($title)) {
            throw new InvalidTitleException('Titleは必須項目です');
        }

        if (is_null($createdAt)) {
            throw new InvalidArgumentException('createdAt is required');
        }

        $this->id = $id;
        $this->userId = $userId;
        $this->mainCategoryId = $mainCategoryId;
        $this->subCategoryId = $subCategoryId;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * IDを取得
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id->value();
    }

    /**
     * User IDを取得
     *
     * @return int
     */
    public function userId(): int
    {
        return $this->userId->value();
    }

    /**
     * メインカテゴリーIDを取得
     *
     * @return int
     */
    public function mainCategoryId(): int
    {
        return $this->mainCategoryId->value();
    }

    /**
     * サブカテゴリーIDを取得
     *
     * @return int|null
     */
    public function subCategoryId(): int|null
    {
        return $this->subCategoryId ? $this->subCategoryId->value() : null;
    }

    /**
     * タイトルを取得
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title->value();
    }

    /**
     * 本文を取得
     *
     * @return string|null
     */
    public function content(): string|null
    {
        return $this->content ? $this->content->value() : null;
    }

    /**
     * 登録日時を取得
     *
     * @return string
     */
    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * 更新日時を取得
     *
     * @return string|null
     */
    public function updatedAt(): string|null
    {
        return isset($this->updatedAt) ? $this->updatedAt->format('Y-m-d H:i:s') : null;
    }

    /**
     * メインカテゴリーIDを変更
     *
     * @param CategoryId $mainCategoryId
     * @return void
     */
    public function changeMainCategoryId(CategoryId $mainCategoryId): void
    {
        $this->mainCategoryId = $mainCategoryId;
        $this->changeUpdatedAt();
    }

    /**
     * サブカテゴリーIDを変更
     *
     * @param CategoryId|null $mainCategoryId
     * @return void
     */
    public function changeSubCategoryId(?CategoryId $subCategoryId): void
    {
        $this->subCategoryId = $subCategoryId;
        $this->changeUpdatedAt();
    }

    /**
     * タイトルを変更
     *
     * @param Title $title
     * @return void
     */
    public function changeTitle(Title $title): void
    {
        $this->title = $title;
        $this->changeUpdatedAt();
    }

    /**
     * 本文を変更
     *
     * @param Content|null $content
     * @return void
     */
    public function changeContent(?Content $content): void
    {
        $this->content = $content;
        $this->changeUpdatedAt();
    }

    /**
     * 更新日時を変更
     *
     * @return void
     */
    private function changeUpdatedAt(): void
    {
        $this->updatedAt = new DateTime(date("Y-m-d H:i:s"));
    }

    public function equals(?Entity $other): bool
    {
        if (is_null($other)) {
            return false;
        }

        if ($this === $other) {
            return true;
        }

        return $this->id === $other->id();
    }
}
