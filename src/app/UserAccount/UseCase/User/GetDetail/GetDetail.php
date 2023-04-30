<?php
namespace App\UserAccount\UseCase\User\GetDetail;


use Domain\UserAccount\Models\User\Id;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class GetDetail implements GetDetailInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Id $id): UserData
    {
        $user = $this->userRepository->find($id);

        if (is_null($user)) {
            throw new UserNotFoundException('ユーザーが見つかりませんでした');
        }

        return new UserData($user);
    }
}
