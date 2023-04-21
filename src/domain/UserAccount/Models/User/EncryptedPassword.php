<?php
namespace Domain\UserAccount\Models\User;

use InvalidArgumentException;
use Domain\UserAccount\Models\ValueObject;

class EncryptedPassword implements ValueObject
{
    private string $value;

    public function __construct(string $encryptedPassword)
    {
        if (is_null($encryptedPassword)) {
            throw new InvalidArgumentException('パスワードが空です');
        }

        $this->value = $encryptedPassword;
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
