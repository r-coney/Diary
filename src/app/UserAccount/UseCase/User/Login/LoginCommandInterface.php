<?php
namespace App\UserAccount\UseCase\User\Login;

interface LoginCommandInterface
{
    /**
     * 入力されたパスワードを取得
     *
     * @return string
     */
    public function email(): string;

    /**
     * 入力されたパスワードを取得
     *
     * @return string
     */
    public function password(): string;
}
