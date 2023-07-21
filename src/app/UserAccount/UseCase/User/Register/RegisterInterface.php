<?php
namespace App\UserAccount\UseCase\User\Register;

use Domain\UserAccount\Models\User\User;

interface RegisterInterface
{
    /**
     * ユーザーアカウントを新規登録
     *
     * @param RegisterCommandInterface $registerCommand
     * @throws CanNotRegisterUserException
     * @return User
     */
    public function __invoke(RegisterCommandInterface $registerCommand): User;
}
