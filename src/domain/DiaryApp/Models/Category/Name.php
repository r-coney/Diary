<?php
namespace Domain\DiaryApp\Models\Category;

use Domain\DiaryApp\Models\ValueObject;
use Domain\DiaryApp\Exceptions\Category\InvalidNameException;

class Name implements ValueObject
{
    private string $value;

    public function __construct(string $name)
    {
        if (is_null($name) || empty($name)) {
            throw new InvalidNameException('カテゴリー名は必須です');
        }

        if (mb_strlen($name) > 100) {
            throw new InvalidNameException('カテゴリー名は100文字以内で入力してください');
        }

        $this->value = $name;
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
