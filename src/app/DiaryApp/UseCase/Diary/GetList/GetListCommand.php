<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

use App\DiaryApp\UseCase\Diary\GetList\GetListCommandInterface;

class GetListCommand Implements GetListCommandInterface
{
    private int $userId;
    private int $perPage;
    private int $page;

    public function __construct(
        int $userId,
        int $perPage,
        int $page
    ) {
        $this->userId = $userId;
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function page(): int
    {
        return $this->page;
    }
}
