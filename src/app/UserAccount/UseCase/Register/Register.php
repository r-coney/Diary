<?php
namespace App\UserAccount\UseCase\Register;

use DateTime;
use Illuminate\Support\Facades\DB;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Services\UserService;
use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;

class Register implements RegisterInterface
{
    private FactoryInterface $userFactory;
    private UserService $UserService;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        FactoryInterface $userFactory,
        UserService $userService,
        UserRepositoryInterface $userRepository
    ) {
        $this->userFactory = $userFactory;
        $this->UserService = $userService;
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterCommandInterface $registerCommand): void
    {
        // トランザクション開始
        DB::transaction(function ($registerCommand) {
            // ユーザーを作成
            $user = $this->userFactory->create(
                new Name($registerCommand->name()),
                new Email($registerCommand->email()),
                new Password($registerCommand->password()),
                new DateTime(),
            );

            // ユーザーがすでに存在しないか判定
            if ($this->UserService->exists($user)) {
                throw new CanNotRegisterUserException('ユーザーは既に存在しています');
            }

            // ユーザーを保存
            $this->userRepository->save($user);
        });
    }
}
