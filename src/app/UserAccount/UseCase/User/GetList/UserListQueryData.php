<?php
namespace App\UserAccount\UseCase\User\GetList;

class UserListQueryData implements UserListQueryDataInterface
{
    private array $userList;
    private int $currentPage;
    private int $totalPages;

    public function __construct(
        array $userList,
        int $currentPage,
        int $totalPages
    ) {
        $this->userList = $userList;
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
    }

    public function userList(): array
    {
        return $this->userList;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function totalPages(): int
    {
        return $this->totalPages;
    }
}
