<?php
namespace Domain\UserAccount\Models\User;

use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;

interface RepositoryInterface
{
    /**
     * idでユーザーを取得する
     *
     * @param Id $id
     * @return User|null
     */
    public function find(Id $id): ?User;

    /**
     * メールアドレスでユーザーを取得する
     *
     * @param Email $email
     * @return User|null
     */
    public function findByEmail(Email $email): ?User;

    /**
     * ユーザーエンティティを永続化
     *
     * @param User $user
     * @return User
     */
    public function save(User $user): User;
}
