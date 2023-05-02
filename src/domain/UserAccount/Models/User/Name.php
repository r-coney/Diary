<?php
namespace Domain\UserAccount\Models\User;

use Domain\UserAccount\Exceptions\User\InvalidNameException;
use Domain\UserAccount\Models\ValueObject;

class Name implements ValueObject
{
    private string $value;

    public function __construct(string $name)
    {
        if (empty($name) || is_null($name)) {
            throw new InvalidNameException('名前が存在しません');
        }

        if (mb_strlen($name) > 800) {
            throw new InvalidNameException('名前は800文字以内で入力してください');
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
