<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\ValueObject;
use Domain\DiaryApp\Exceptions\Diary\InvalidContentException;

class Content implements ValueObject
{
    private string $value;

    public function __construct(?string $content)
    {
        if (isset($content) && mb_strlen($content) > 500) {
            throw new InvalidContentException('本文は500文字以内で入力してください');
        }

        $this->value = $content ?? '';
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
