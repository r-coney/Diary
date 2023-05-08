<?php
namespace App\UserAccount\UseCase\User\GetList;

class GetListCommand implements GetListCommandInterface
{
    private int $page;
    private int $perPage;

    public function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
