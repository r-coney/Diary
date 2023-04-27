<?php
namespace App\UserAccount\UseCase\User\Register;

interface RegisterCommandInterface
{
    /**
     * 入力された名前を取得
     *
     * @return string
     */
    public function name(): string;

    /**
     * 入力されたメールアドレスを取得
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

    /**
     * 入力された確認用のパスワードを取得
     *
     * @return string
     */
    public function passwordConfirmation(): string;
}
