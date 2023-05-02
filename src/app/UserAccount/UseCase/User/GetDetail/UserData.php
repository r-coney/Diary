<?php
namespace App\UserAccount\UseCase\User\GetDetail;

use Domain\UserAccount\Models\User\User;

class UserData
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $registeredDateTime;
    public ?string $updatedDateTime;
    public ?string $deletedDateTime;

    public function __construct(User $user)
    {
        $this->id = $user->id();
        $this->name = $user->name();
        $this->email = $user->email();
        $this->password = $user->password();
        $this->registeredDateTime = $user->registeredDateTime();
        $this->updatedDateTime = $user->updatedDateTime();
        $this->deletedDateTime = $user->deletedDateTime();
    }
}
