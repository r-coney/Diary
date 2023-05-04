<?php
namespace App\UserAccount\UseCase\User\Edit;

class EditCommand implements EditCommandInterface
{
    private int $userId;
    private ?string $newName;
    private ?string $newEmail;
    private ?string $newPassword;
    private ?string $newPasswordConfirmation;
    private string $currentPassword;

    public function __construct(
        int $userId,
        ?string $newName = null,
        ?string $newEmail = null,
        ?string $newPassword = null,
        ?string $newPasswordConfirmation = null,
        string $currentPassword
    ) {
        $this->userId = $userId;
        $this->newName = $newName;
        $this->newEmail = $newEmail;
        $this->newPassword = $newPassword;
        $this->newPasswordConfirmation = $newPasswordConfirmation;
        $this->currentPassword = $currentPassword;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function newName(): ?string
    {
        return $this->newName;
    }

    public function newEmail(): ?string
    {
        return $this->newEmail;
    }

    public function newPassword(): ?string
    {
        return $this->newPassword;
    }

    public function newPasswordConfirmation(): ?string
    {
        return $this->newPasswordConfirmation;
    }

    public function currentPassword(): string
    {
        return $this->currentPassword;
    }
}