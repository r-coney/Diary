<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface;
use Domain\UserAccount\Models\User\Id;

class Detail extends Controller
{
    private GetDetailInterface $getDetail;

    public function __construct(GetDetailInterface $getDetail)
    {
        $this->getDetail = $getDetail;
    }

    public function __invoke(int $id)
    {
        $userData = ($this->getDetail)(new Id($id));

        return view('user_account.user.detail', [
            'userData' => $userData,
        ]);
    }
}
