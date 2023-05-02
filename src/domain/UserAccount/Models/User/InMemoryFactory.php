<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\FactoryInterface;
use Domain\UserAccount\Models\User\EncryptedPassword;

class InMemoryFactory implements FactoryInterface
{
    private int $currentId;

    public function __construct()
    {
        $this->currentId = 0;
    }

    public function create(
        Name $name,
        Email $email,
        Password $password,
        DateTime $registeredDateTime,
        DateTime $updatedDateTime = null,
        DateTime $deletedDateTime = null,
        Id $id = null
    ): User {
        $this->currentId++;

        if (is_null($id)) {
            $id = new Id($this->currentId);
        }


        return new User(
            $id,
            $name,
            $email,
            new EncryptedPassword($password->value()),
            $registeredDateTime,
            $updatedDateTime,
            $deletedDateTime,
        );
    }
}