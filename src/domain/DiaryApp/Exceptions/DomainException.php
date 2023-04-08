<?php

namespace Domain\DiaryApp\Exceptions;

use Exception;

abstract class DomainException extends Exception
{
    protected string $errorCode;

    public function __construct(string $message, int $errorCode = 400)
    {
        parent::__construct($message);

        $this->errorCode = $errorCode;
    }

    /**
     * エラーコードを取得
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * 例外が発生した場合の処理
     *
     * @return void
     */
    abstract public function render(): void;
}
