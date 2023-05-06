<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Edit;

use Tests\TestCase;
use App\UserAccount\UseCase\User\Edit\EditCommand;

class EditCommandTest extends TestCase
{
    /**
     * @test
     */
    public function 各値が取得できること(): void
    {
        $userId = 1;
        $newName = 'newName';
        $newEmail = 'email@example.com';
        $newPassword = 'newPassword';
        $newPasswordConfirmation = 'newPassword';
        $currentPassword = 'currentPassword';

        $command = new EditCommand(
            $userId,
            $newName,
            $newEmail,
            $newPassword,
            $newPasswordConfirmation,
            $currentPassword
        );

        $this->assertSame($userId, $command->userId());
        $this->assertSame($newName, $command->newName());
        $this->assertSame($newEmail, $command->newEmail());
        $this->assertSame($newPassword, $command->newPassword());
        $this->assertSame($newPasswordConfirmation, $command->newPasswordConfirmation());
        $this->assertSame($currentPassword, $command->currentPassword());
    }
}
