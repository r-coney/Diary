<?php
namespace Domain\UserAccount\Models\User;

use Domain\UserAccount\Models\ValueObject;
use Domain\UserAccount\Exceptions\User\InvalidEmailException;

class Email implements ValueObject
{
    private string $value;

    public function __construct(string $email)
    {
        if (strlen($email) > 255) {
            throw new InvalidEmailException('メールアドレスが長すぎます');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('メールアドレスが無効です');
        }

        $this->value = $email;
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
