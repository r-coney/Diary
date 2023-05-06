<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\FactoryInterface;

class InMemoryFactory implements FactoryInterface
{
    private int $currentId;
    private Encryptor $encryptor;

    public function __construct(Encryptor $encryptor)
    {
        $this->currentId = 0;
        $this->encryptor = $encryptor;
    }

    public function create(
        Name $name,
        Email $email,
        Password|EncryptedPassword $password,
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
            is_a($password, EncryptedPassword::class) ? $password : $password->encrypt($this->encryptor),
            $registeredDateTime,
            $updatedDateTime,
            $deletedDateTime,
        );
    }
}