<?php
namespace App\UserAccount\Infrastructure\InMemory\Queries;

use App\UserAccount\UseCase\User\GetList\UserListQueryData;
use App\UserAccount\UseCase\User\GetList\GetListCommandInterface;
use App\UserAccount\UseCase\User\QueryServiceInterface as UserQueryServiceInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class UserQueryService implements UserQueryServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(GetListCommandInterface $command): UserListQueryData
    {
        $offset = ($command->page() - 1) * $command->perPage();
        $pagedUsers = array_slice($this->userRepository->store(), $offset, $command->perPage());
        $totalPages = ceil(count($this->userRepository->store()) / $command->perPage());

        return new UserListQueryData(
            userList: $pagedUsers,
            currentPage: $command->page(),
            totalPages: $totalPages
        );
    }
}