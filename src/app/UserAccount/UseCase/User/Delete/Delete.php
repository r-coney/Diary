<?php
namespace App\UserAccount\UseCase\User\Delete;

use DateTime;
use Exception;
use App\UserAccount\UseCase\User\Delete\DeleteInterface;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class Delete implements DeleteInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Id $id): array
    {
        $user = $this->userRepository->find($id);

        try {
            if (is_null($user)) {
                throw new UserNotFoundException('ユーザーが見つかりませんでした');
            }

            DB::transaction(function () use ($user) {
                $user->changeDeletedDateTime(new DateTime());
                $this->userRepository->save($user);
            });

            $response = [
                'status' => 'success'
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());

            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $response;
    }
}
