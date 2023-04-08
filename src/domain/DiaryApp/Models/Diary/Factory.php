<?php
namespace Domain\DiaryApp\Models\Diary;

use DateTime;
use Illuminate\Support\Facades\DB;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Diary\FactoryInterface;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use stdClass;

class Factory implements FactoryInterface
{
    public function create(
        UserId $userId,
        CategoryId $mainCategoryId,
        ?CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        DateTime $createdAt,
        ?DateTime $updatedAt = null,
        ?Id $id = null
    ): Diary {
        if (is_null($id)) {
            $id = $this->getNextSequenceNumber();
        }

        return new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt,
            $updatedAt
        );
    }

    /**
     * シーケンスIDを取得
     *
     * @return Id
     */
    private function getNextSequenceNumber(): Id
    {
        $lastNumber = DB::connection('sequence_db')
            ->table('sequences')
            ->where('entity', 'diary')
            ->lockForUpdate()
            ->first();

        if (is_null($lastNumber)) {
            $lastNumber = new stdClass();
            $lastNumber->id = 0;
        }

        $newNumber = $lastNumber->id + 1;

        DB::transaction(function () use ($newNumber) {
            DB::connection('sequence_db')
                ->table('sequences')
                ->updateOrInsert(
                    ['entity' => 'diary'],
                    ['id' => $newNumber],
                );
        });

        return new Id($newNumber);
    }
}
