<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\ValueObject;
use Domain\DiaryApp\Exceptions\Diary\InvalidTitleException;

class Title implements ValueObject
{
    private string $value;

    public function __construct(string $title)
    {
        if (is_null($title) || empty($title)) {
            throw new InvalidTitleException('タイトルは必須です');
        }

        if (mb_strlen($title) > 100) {
            throw new InvalidTitleException('タイトルは100文字以内で入力してください');
        }

        $this->value = $title;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(?ValueObject $other): bool
    {
        if (is_null($other)) {
            return false;
        }

        if ($this === $other) {
            return true;
        }

        return $this->value() === $other->value();
    }
}
