<?php
namespace Domain\UserAccount\Services;

use Domain\UserAccount\Models\User\User;

class UserService
{
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function exists(User $user): bool
    {
        $found = $this->userRepository->findByEmail(new Email($user->email()));

        return $found !== null;
    }
}
