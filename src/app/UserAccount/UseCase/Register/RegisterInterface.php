<?php
namespace App\UserAccount\UseCase\Register;

interface RegisterInterface
{
    public function __invoke(RegisterCommandInterface $registerCommand): void;
}
