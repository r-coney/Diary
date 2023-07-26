<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Edit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\Edit\EditCommand;

class EditCommandTest extends TestCase
{
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->mock(Request::class);
    }

    /**
     * @test
     */
    public function 各値が取得できること(): void
    {
        $this->setRequestReturnValue(
            name: 'newName',
            email: 'email@example.com',
            password: 'newPassword',
            passwordConfirmation: 'newPassword',
            currentPassword: 'currentPassword'
        );

        $userId = 1;
        $command = new EditCommand(
            $userId,
            $this->request
        );

        $this->assertSame($userId, $command->userId());
        $this->assertSame($this->request->input(UserConst::INPUT_NEW_NAME), $command->newName());
        $this->assertSame($this->request->input(UserConst::INPUT_NEW_EMAIL), $command->newEmail());
        $this->assertSame($this->request->input(UserConst::INPUT_NEW_PASSWORD), $command->newPassword());
        $this->assertSame($this->request->input(UserConst::INPUT_NEW_PASSWORD_CONFIRMATION), $command->newPasswordConfirmation());
        $this->assertSame($this->request->input(UserConst::INPUT_CURRENT_PASSWORD), $command->currentPassword());
    }

    /**
     * Requestの返り値を設定
     *
     * @param string|null $name
     * @param string|null $email
     * @param string|null $password
     * @param string|null $passwordConfirmation
     * @param string|null $currentPassword
     * @return bool
     */
    private function setRequestReturnValue(
        ?string $name,
        ?string $email,
        ?string $password,
        ?string $passwordConfirmation,
        ?string $currentPassword
    ): bool {
        $this->request->shouldReceive('input')
        ->andReturnUsing(function ($inputName) use ($name, $email, $password, $passwordConfirmation, $currentPassword) {
            switch ($inputName) {
                case UserConst::INPUT_NEW_NAME:
                    return $name;
                case UserConst::INPUT_NEW_EMAIL:
                    return $email;
                case UserConst::INPUT_NEW_PASSWORD;
                    return $password;
                case UserConst::INPUT_NEW_PASSWORD_CONFIRMATION;
                    return $passwordConfirmation;
                case UserConst::INPUT_CURRENT_PASSWORD:
                    return $currentPassword;
                default:
                    throw new InvalidArgumentException($inputName . 'not found.');
            }
        });

        if ($this->request->input(UserConst::INPUT_NEW_NAME) !== $name) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_NEW_EMAIL) !== $email) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_NEW_PASSWORD) !== $password) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_NEW_PASSWORD_CONFIRMATION) !== $passwordConfirmation) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_CURRENT_PASSWORD) !== $currentPassword) {
            return false;
        }

        return true;
    }
}
