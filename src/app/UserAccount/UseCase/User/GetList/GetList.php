<?php
namespace App\UserAccount\UseCase\User\GetList;

use App\UserAccount\UseCase\User\GetList\UserListQueryData;
use App\UserAccount\UseCase\User\QueryServiceInterface as UserQueryServiceInterface;

class GetList implements GetListInterface
{
    private UserQueryServiceInterface $userQueryService;

    public function __construct(UserQueryServiceInterface $userQueryService)
    {
        $this->userQueryService = $userQueryService;
    }

    public function __invoke(GetListCommandInterface $command): UserListQueryData
    {
        $userList = $this->userQueryService->getAll($command);

        return $userList;
    }
}
