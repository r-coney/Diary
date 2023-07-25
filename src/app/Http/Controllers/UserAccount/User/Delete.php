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
        $result = ($this->delete)(new Id($id));
        if (!$result->hasError()) {
            $deletedUser = $result->value();
            $response = [
                'status' => 'success',
                'deletedUser' => [
                    'id' => $deletedUser->id(),
                    'name' => $deletedUser->name(),
                    'email' => $deletedUser->email(),
                    'registered_datetime' => $deletedUser->registeredDatetime(),
                    'updatedDateTime' => $deletedUser->updatedDateTime(),
                    'deletedDateTime' => $deletedUser->deletedDateTime(),
                ],
            ];
            $statusCode = 200;
        } else {
            $response = [
                'status' => 'error',
                'message' => $result->error(),
            ];
            $statusCode = 400;
        }

        return response()->json($response, $statusCode);
    }
}
