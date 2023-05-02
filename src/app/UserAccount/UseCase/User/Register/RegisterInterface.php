<?php
namespace App\UserAccount\UseCase\User\Register;


interface RegisterInterface
{
    public function __invoke(RegisterCommandInterface $registerCommand): array;
}
