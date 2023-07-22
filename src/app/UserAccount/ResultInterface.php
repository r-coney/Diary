<?php
namespace App\UserAccount;

interface ResultInterface
{
    /**
     * 成功のResultを構築
     * @param mixed $value
     * @return Result
     */
    public static function ofValue(mixed $value): ResultInterface;

    /**
     * errorのResultを構築
     * @param mixed $error
     * @return Result
     */
    public static function ofError(mixed $error): ResultInterface;

    /**
     * Resultがエラーか判定
     *
     * @return bool
     */
    public function hasError(): bool;

    /**
     * 成功時の値を取得
     *
     * @return mixed
     */
    public function value(): mixed;

    /**
     * エラー時の値を取得
     *
     * @return mixed
     */
    public function error(): mixed;
}
