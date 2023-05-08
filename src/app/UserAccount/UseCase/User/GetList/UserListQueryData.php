<?php
namespace App\UserAccount\UseCase\User\GetList;

class UserListQueryData implements UserListQueryDataInterface
{
    private array $userList;
    private int $totalPages;

    public function __construct(
        array $userList,
        int $totalPages
    ) {
        $this->userList = $userList;
        $this->totalPages = $totalPages;
    }

    public function userList(): array
    {
        return $this->userList;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }
}
