<?php

namespace App\Http\Controllers\UserAccount\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Edit\EditCommand;
use App\UserAccount\UseCase\User\Edit\EditInterface;

class Update extends Controller
{
    private $edit;

    public function __construct(EditInterface $edit)
    {
        $this->edit = $edit;
    }

    public function __invoke(Request $request, int $id)
    {
        ($this->edit)(new EditCommand($id, $request));

        return redirect()->route('userAccount.user.detail', ['id' => $id]);
    }
}
