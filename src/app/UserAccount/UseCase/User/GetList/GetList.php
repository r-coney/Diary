<?php
namespace App\UserAccount\UseCase\User\GetList;

use Exception;
use App\UserAccount\Result;
use App\UserAccount\UseCase\User\QueryServiceInterface as UserQueryServiceInterface;

class GetList implements GetListInterface
{
    private UserQueryServiceInterface $userQueryService;

    public function __construct(UserQueryServiceInterface $userQueryService)
    {
        $this->userQueryService = $userQueryService;
    }

    public function __invoke(GetListCommandInterface $command): Result
    {
        try {
            $result = Result::ofValue($this->userQueryService->getAll($command));
        } catch (Exception $e) {
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
