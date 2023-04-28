<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;

interface FactoryInterface
{
    public function create(
        Name $name,
        Email $email,
        Password $password,
        DateTime $registeredDateTime,
        DateTime $updatedDateTime = null,
        DateTime $deletedDateTime = null,
        Id $id = null
    );
}
