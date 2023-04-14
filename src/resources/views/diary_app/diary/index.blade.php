<h2>日記一覧</h2>

@foreach ($diaryList as $diary)
    {{ $diary->title }}
    {{ $diary->content }}
    {{ $diary->mainCategoryId }}
    {{ $diary->subCategoryId }}
    <a href="{{ route('diaryApp.diary.detail', ['id' => $diary->id]) }}">詳細</a>
@endforeach
