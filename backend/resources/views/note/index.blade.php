@extends('layouts.default')

@section('title', 'Note')
@section('js', 'note/index.js')

@section('main')

  <h1 class="heading-lv1">Notes</h1>

  <div class="section">
    <div id="_tab">
      <ul>
        <li><a href="#_tab-search">検索</a></li>
        <li><a href="#_tab-menu">メニュー</a></li>
      </ul>
      {{---------------------------------------- 検索フォーム ----------------------------------------}}
      <div id="_tab-search">
        <form action="/notes" method="get">
          <table class="table">
            <tbody>
              <tr>
                <th><label for="search-category_id">カテゴリ</label></th>
                <td>
                  <x-forms.drop-box 
                    id="search-category_id" 
                    name="category_id" 
                    hasEmpty="true" 
                    :options="$categories"
                    :selected="$search['category_id']"
                  />
                </td>
                <th><label for="search-variety_id">バラエティ</label></th>
                <td>
                  <x-forms.drop-box 
                    id="search-variety_id" 
                    name="variety_id" 
                    hasEmpty="true" 
                    :options="$varieties"
                    :selected="$search['variety_id']"
                  />
                </td>
                <td>
                  <input class="btn" type="submit" value="検索">
                  <a class="btn" href="/notes">リセット</a>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>

      {{---------------------------------------- メニュー ----------------------------------------}}
      <div id="_tab-menu">
        <a href="/notes/create">新規作成</a>
      </div>
    </div>
  </div>

  <section class="section">
    <h2 class="heading-lv2">一覧</h2>
    <table class="vertical-table">
      <thead class="vertical-table__header">
        <tr class="vertical-table__header-row">
          <th>ID.</th>
          <th>分類</th>
          <th>タイトル</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody id="sortdata" class="vertical-table__body">
        @foreach($notes as $note)
          <tr>
            <td>{{ $note->id }}</td>
            <td>
              <span class="badge mb-3">{{ $categories[$note->category_id] }}</span><br>
              <span class="badge badge--sub">{{ $varieties[$note->variety_id] }}</span>
            </td>
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
@endsection