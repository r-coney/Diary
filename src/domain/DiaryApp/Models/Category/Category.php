<?php
namespace Domain\DiaryApp\Models\Category;

use DateTime;
use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Models\Entity;

class Category implements Entity
{
    private Id $id;
    private Name $name;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(
        Id $id,
        Name $name,
        DateTime $createdAt,
        ?DateTime $updatedAt = null
    ) {
        if (is_null($id)) {
            throw new InvalidIdException('Category IDが存在しません');
        }

        if (is_null($name)) {
            throw new InvalidNameException('カテゴリー名は必須項目です');
        }

        if (is_null($createdAt)) {
            throw new InvalidArgumentException('createdAt is required');
        }

        $this->id = $id;
        $this->name = $name;
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
     * 名前を取得
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name->value();
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
     * @return string
     */
    public function updatedAt(): string|null
    {
        return isset($this->updatedAt) ? $this->updatedAt->format('Y-m-d H:i:s') : null;
    }

    /**
     * 名前を変更
     *
     * @param string $name
     * @return void
     */
    public function changeName(Name $name): void
    {
        $this->name = $name;
        $this->changeUpdatedAt();
    }

        /**
     * 更新日時を変更
     *
     * @return void
     */
    private function changeUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function equals(?Entity $other): bool
    {
        if (is_null($other)) {
            return false;
        }

        if ($this === $other) {
            return true;
        }

        return $this->id() === $other->id();
    }
}
