<?php
namespace App\UserAccount\UseCase\User\Edit;

use App\Exceptions\UserAccount\User\UseCase\CanNotEditUserException;
use App\UserAccount\UseCase\User\Edit\EditCommandInterface;
use Illuminate\Support\Facades\DB;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class Edit implements EditInterface
{
    private UserRepositoryInterface $userRepository;
    private Encryptor $encryptor;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Encryptor $encryptor
    ) {
        $this->userRepository = $userRepository;
        $this->encryptor = $encryptor;
    }

    public function __invoke(EditCommandInterface $command): array
    {
        try {
            $user = DB::transaction(function () use ($command) {
                $user = $this->userRepository->find(new Id($command->userId()));

                if (!$user->verifyPassword($this->encryptor, $command->currentPassword())) {
                    throw new CanNotEditUserException('パスワードが一致しません');
                }

                if ($command->hasNewName()) {
                    $user->changeName(new Name($command->newName()));
                }

                if ($command->hasNewEmail()) {
                    $user->changeEmail(new Email($command->newEmail()));
                }

                if ($command->hasNewPassword()) {
                    if ($command->newPassword() !== $command->newPasswordConfirmation()) {
                        throw new CanNotEditUserException('新しいパスワードが確認用のパスワードと一致しません');
                    }

                    $newPassword = new Password($command->newPassword());
                    $user->changePassword($newPassword->encrypt($this->encryptor));
                }

                $this->userRepository->save($user);

                return $user;
            });

            $response = [
                'status' => 'success',
                'user' => [
                    'id' => $user->id(),
                    'name' => $user->name(),
                    'email' => $user->email(),
                    'registeredDateTime' => $user->registeredDateTime(),
                    'updatedDateTime' => $user->updatedDateTime(),
                ],
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());

            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }
}
