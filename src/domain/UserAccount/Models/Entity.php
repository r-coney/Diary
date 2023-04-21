<?php
namespace Domain\UserAccount\Models;

interface Entity
{
    /**
     * idを取得
     *
     * @return mixed
     */
    public function id(): mixed;

    /**
     * エンティティの比較
     *
     * @param Entity|null $other
     * @return bool
     */
    public function equals(?Entity $other): bool;
}
