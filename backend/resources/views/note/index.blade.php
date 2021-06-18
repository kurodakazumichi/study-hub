@extends('layouts.default')

@section('title', 'Note')
@section('js', 'note/index.js')

@section('main')
  <section>
    <h1>Notes</h1>

    <a href="/notes/create">新規作成</a>

    <section>
      <h2>検索フォーム</h2>
      <form action="/studies" method="get">
        <label for="search-category_id">カテゴリ</label>
        <x-forms.drop-box 
          id="search-category_id" 
          name="category_id" 
          hasEmpty="true" 
          :options="$categories"
          :selected="$search['category_id']"
        />
        
        <label for="search-variety_id">バラエティ</label>
        <x-forms.drop-box 
          id="search-variety_id" 
          name="variety_id" 
          hasEmpty="true" 
          :options="$varieties"
          :selected="$search['variety_id']"
        />

        <input type="submit" value="検索">
        <input type="button" value="リセット" onclick="location.href='/notes'; return false;" >
      </form>
    </section>

    <section>
      <h2>一覧</h2>
      <table>
        <thead>
          <tr>
            <th>ID.</th>
            <th>分類</th>
            <th>タイトル</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="sortdata">
          @foreach($notes as $note)
            <tr>
              <td>{{ $note->id }}</td>
              <td>{{ $categories[$note->category_id] }}:{{ $varieties[$note->variety_id] }}</td>
              <td>
                <a href="/notes/{{ $note->id }}/show">{{ $note->title }}</a>
              </td>
              <td>
                <a href="/notes/{{ $note->id }}/edit">編集</a>
              </td>
            </tr>          
          @endforeach

        </tbody>
      </table>  
    </section>


  </section>
@endsection