<?php
namespace Domain\DiaryApp\Models;

interface ValueObject
{
    /**
     * 値の取得
     *
     * @return mixed
     */
    public function value(): mixed;

    /**
     * 値オブジェクトの比較
     *
     * @param ValueObject|null $other
     * @return boolean
     */
    public function equals(?ValueObject $other): bool;
}
