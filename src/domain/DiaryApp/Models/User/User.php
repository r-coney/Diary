<?php
namespace Domain\DiaryApp\Models\User;

use Domain\DiaryApp\Exceptions\User\InvalidIdException;
use Domain\DiaryApp\Models\Entity;
use Domain\DiaryApp\Models\User\Id;
use InvalidArgumentException;

class User implements Entity
{
    private Id $id;
    private string $name;

    public function __construct(
        Id $id,
        string $name
    ) {
        if (is_null($id)) {
            throw new InvalidIdException('User IDが存在しません');
        }

        if (empty($name) || is_null($name)) {
            throw new InvalidArgumentException('User Name が存在しません');
        }

        $this->id = $id;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id->value();
    }

    /**
     * ユーザー名を取得
     */
    public function name(): string
    {
        return $this->name;
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
