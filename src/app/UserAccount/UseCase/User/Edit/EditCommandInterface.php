<?php
namespace App\UserAccount\UseCase\User\Edit;

interface EditCommandInterface
{
    /**
     * ユーザーIDを取得
     *
     * @return int
     */
    public function userId(): int;

    /**
     * 編集後の新しい名前を取得
     *
     * @return string|null
     */
    public function newName(): ?string;

    /**
     * 編集後の新しいメールアドレスを取得
     *
     * @return string|null
     */
    public function newEmail(): ?string;

    /**
     * 編集後の新しいパスワードを取得
     *
     * @return string|null
     */
    public function newPassword(): ?string;

    /**
     * 確認用の新しいパスワードを取得
     *
     * @return string|null
     */
    public function newPasswordConfirmation(): ?string;

    /**
     * 現在のパスワードを取得
     *
     * @return string
     */
    public function currentPassword(): ?string;
}
