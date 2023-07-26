<?php
namespace App\UserAccount\UseCase\User\GetDetail;

use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use App\UserAccount\Result;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use Exception;

class GetDetail implements GetDetailInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Id $id): Result
    {
        try {
            $user = $this->userRepository->find($id);
            if (is_null($user)) {
                throw new UserNotFoundException('User not found.');
            }

            $result = Result::ofValue(new UserData($user));
        } catch (Exception $e) {
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
