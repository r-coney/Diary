<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\EncryptedPassword;

interface FactoryInterface
{
    public function create(
        Name $name,
        Email $email,
        Password|EncryptedPassword $password,
        DateTime $registeredDateTime,
        DateTime $updatedDateTime = null,
        DateTime $deletedDateTime = null,
        Id $id = null
    ): User;
}
