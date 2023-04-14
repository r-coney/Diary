<?php
namespace App\DiaryApp\UseCase\Diary\Edit;

interface EditCommandInterface
{
    /**
     * 編集対象の日記のIDを取得
     *
     * @return int
     */
    public function diaryId(): int;

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
     * 選択されたメインカテゴリーIDを取得
     *
     * @return int
     */
    public function mainCategoryId(): int;

    /**
     * 選択されたサブカテゴリーIDを取得
     *
     * @return integer|null
     */
    public function subCategoryId(): ?int;

    /**
     * サブカテゴリーが選択されているかを判定
     *
     * @return bool
     */
    public function hasSubCategoryId(): bool;
}
