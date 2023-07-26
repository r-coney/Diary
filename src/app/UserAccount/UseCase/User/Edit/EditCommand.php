<?php
namespace App\UserAccount\UseCase\User\Edit;

use Illuminate\Http\Request;
use App\UserAccount\Consts\UserConst;

class EditCommand implements EditCommandInterface
{
    private int $userId;
    private ?string $newName;
    private ?string $newEmail;
    private ?string $newPassword;
    private ?string $newPasswordConfirmation;
    private ?string $currentPassword;

    public function __construct(
        int $userId,
        Request $request
    ) {
        $this->userId = $userId;
        $this->newName = $request->input(UserConst::INPUT_NEW_NAME);
        $this->newEmail = $request->input(UserConst::INPUT_NEW_EMAIL);
        $this->newPassword = $request->input(UserConst::INPUT_NEW_PASSWORD);
        $this->newPasswordConfirmation = $request->input(UserConst::INPUT_NEW_PASSWORD_CONFIRMATION);
        $this->currentPassword = $request->input(UserConst::INPUT_CURRENT_PASSWORD);
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function newName(): ?string
    {
        return $this->newName;
    }

    public function hasNewName(): bool
    {
        return isset($this->newName);
    }

    public function newEmail(): ?string
    {
        return $this->newEmail;
    }

    public function hasNewEmail(): bool
    {
        return isset($this->newEmail);
    }

    public function newPassword(): ?string
    {
        return $this->newPassword;
    }

    public function hasNewPassword(): bool
    {
        return isset($this->newPassword);
    }

    public function newPasswordConfirmation(): ?string
    {
        return $this->newPasswordConfirmation;
    }

    public function currentPassword(): ?string
    {
        return $this->currentPassword;
    }
}