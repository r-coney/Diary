<?php
namespace Domain\UserAccount\Models\User;

use Domain\UserAccount\Models\ValueObject;
use Domain\UserAccount\Exceptions\User\InvalidIdException;

class Id implements ValueObject
{
    private int $value;

    public function __construct(int $id)
    {
        if (is_null($id)) {
            throw new InvalidIdException('User IDが存在しません');
        }

        if (is_float($id)) {
            throw new InvalidIdException('無効なUser IDが指定されました');
        }

        if ($id < 0) {
            throw new InvalidIdException('無効なUser IDが指定されました');
        }

        $this->value = $id;
    }

    public function value(): int
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
