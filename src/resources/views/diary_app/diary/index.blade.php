<h2>日記一覧</h2>

@foreach ($diaryList as $diary)
    {{ $diary->title }}
    {{ $diary->content }}
    {{ $diary->mainCategoryId }}
    {{ $diary->subCategoryId }}
@endforeach
