<?php
namespace App\UserAccount\UseCase\User\Edit;

use App\UserAccount\UseCase\User\Edit\EditCommandInterface;

interface  EditInterface
{
    public function __invoke(EditCommandInterface $command): array;
}
