<h2>日記詳細★</h2>

{{ $diaryData->title }}
{{ $diaryData->content }}
{{ $diaryData->mainCategoryName }}
{{ $diaryData->subCategoryName }}
{{ $diaryData->createdAt }}
{{ $diaryData->updatedAt }}

<form action='{{ route('diaryApp.diary.delete', ['id' => $diaryData->id]) }}' method='post'>
    @method('DELETE')
    @csrf
    <input type="submit" value='削除'>
</form>
