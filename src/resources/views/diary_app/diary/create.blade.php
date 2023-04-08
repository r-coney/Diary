<h2>日記作成</h2>

<form action='{{ route('diaryApp.diary.store') }}' method='post'>
    @csrf
    <div>
        <h3>タイトル</h3>
        <input type='text' name='title' />
    </div>
    <div>
        <h3>本文</h3>
        <input type='content' name='content' />
    </div>
    <div>
        <h3>メインカテゴリー</h3>
        <input type='radio' name='mainCategoryId' value='1' />カテゴリー1
        <input type='radio' name='mainCategoryId' value='2' />カテゴリー2
    </div>
    <div>
        <h3>サブカテゴリー</h3>
        <input type='radio' name='subCategoryId' value='1' />カテゴリー1
        <input type='radio' name='subCategoryId' value='2' />カテゴリー2
    </div>
    <input type='submit' value='作成'>
</form>