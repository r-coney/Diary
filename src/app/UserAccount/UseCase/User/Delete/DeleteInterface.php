<?php
namespace App\UserAccount\UseCase\User\Delete;

use Domain\UserAccount\Models\User\Id;

interface DeleteInterface
{
    public function __invoke(Id $id): array;
}
