<h1>カテゴリ一覧</h1>

@foreach($categories as $category)
<a href="/categories/{{ $category->id }}/edit">
  {{ $category->id }}:{{ $category->name }}:{{ $category->order }}
</a><br>

@endforeach

<a href="/categories/create">新規作成</a>