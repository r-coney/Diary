<?php
namespace App\UserAccount;

use App\UserAccount\ResultInterface;


class Result implements ResultInterface
{
    private mixed $value;
    private mixed $error;

    private function __construct(mixed $value, mixed $error)
    {
        $this->value = $value;
        $this->error = $error;
    }

    public static function ofValue(mixed $value): ResultInterface
    {
        return new Result(value: $value, error: null);
    }

    public static function ofError(mixed $error): ResultInterface
    {
        return new Result(value: null, error: $error);
    }

    public function hasError(): bool
    {
        return $this->error !== null;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function error(): mixed
    {
        return $this->error;
    }
}