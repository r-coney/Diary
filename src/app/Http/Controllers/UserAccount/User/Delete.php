<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use Domain\UserAccount\Models\User\Id;
use App\UserAccount\UseCase\User\Delete\DeleteInterface;

class Delete extends Controller
{
    private DeleteInterface $delete;

    public function __construct(DeleteInterface $delete)
    {
        $this->delete = $delete;
    }

    public function __invoke(int $id)
    {
        ($this->delete)(new Id($id));
    }
}
