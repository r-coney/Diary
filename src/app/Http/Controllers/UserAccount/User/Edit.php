<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface;
use Domain\UserAccount\Models\User\Id;

class Edit extends Controller
{
    private $getDetail;

    public function __construct(GetDetailInterface $getDetail)
    {
        $this->getDetail = $getDetail;
    }

    public function __invoke(int $id)
    {
        $userData = ($this->getDetail)(new Id($id));

        return view('user_account.user.edit', ['userData' => $userData]);
    }
}
