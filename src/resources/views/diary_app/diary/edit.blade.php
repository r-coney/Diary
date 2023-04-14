<h2>日記編集</h2>

<form action='{{ route('diaryApp.diary.update', ['id' => $diaryData->id]) }}' method='post'>
    @method('PUT')
    @csrf
    <div>
        <h3>タイトル</h3>
        <input type='text' name='title' value='{{ $diaryData->title }}'/>
    </div>
    <div>
        <h3>本文</h3>
        <input type='content' name='content' value='{{ $diaryData->content }}' />
    </div>
    <div>
        <h3>メインカテゴリー</h3>
        <input type='radio' name='mainCategoryId' value='1' @if ($diaryData->mainCategoryId === 1) @checked(true) @endif />カテゴリー1
        <input type='radio' name='mainCategoryId' value='2' @if ($diaryData->mainCategoryId === 2) @checked(true) @endif />カテゴリー2
    </div>
    <div>
        <h3>サブカテゴリー</h3>
        <input type='radio' name='subCategoryId' value='1' @if ($diaryData->subCategoryId === 1) @checked(true) @endif />カテゴリー1
        <input type='radio' name='subCategoryId' value='2' @if ($diaryData->mainCategoryId === 2) @checked(true) @endif />カテゴリー2
    </div>
    <input type='submit' value='編集'>
</form>