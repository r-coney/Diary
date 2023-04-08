<?php
namespace App\DiaryApp\UseCase\Diary\Create;

interface CreateCommandInterface
{
    /**
     * userIdを取得
     *
     * @return int
     */
    public function userId(): int;

    /**
     * 入力されたタイトルを取得
     *
     * @return string
     */
    public function title(): string;

    /**
     * 入力された本文を取得
     *
     * @return string|null
     */
    public function content(): ?string;

    /**
     * 選択されたメインカテゴリーを取得
     *
     * @return int
     */
    public function mainCategoryId(): int;

    /**
     * 選択されたサブカテゴリーを取得
     *
     * @return int|null
     */
    public function subCategoryId(): ?int;
}
