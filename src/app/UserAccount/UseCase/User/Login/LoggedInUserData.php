<?php
namespace App\UserAccount\UseCase\User\Login;

use App\Models\AccessToken;
use Domain\UserAccount\Models\User\User;

class LoggedInUserData
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $registeredDateTime;
    public ?string $updatedDateTime;
    public ?string $deletedDateTime;
    public string $accessToken;

    public function __construct(User $user, AccessToken $accessToken)
    {
        $this->id = $user->id();
        $this->name = $user->name();
        $this->email = $user->email();
        $this->password = $user->password();
        $this->registeredDateTime = $user->registeredDateTime();
        $this->updatedDateTime = $user->updatedDateTime();
        $this->deletedDateTime = $user->deletedDateTime();
        $this->accessToken = $accessToken->token;
    }
}