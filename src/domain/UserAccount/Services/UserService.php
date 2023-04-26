<?php
namespace Domain\UserAccount\Services;

use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * ユーザーが存在するか判定
     *
     * @param User $user
     * @return bool
     */
    public function exists(User $user): bool
    {
        $found = $this->userRepository->findByEmail(new Email($user->email()));

        return $found !== null;
    }
}
