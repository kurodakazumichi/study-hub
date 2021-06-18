@extends('layouts.default')

@section('title', 'Study')
@section('js', 'study/index.js')

@section('main')
  <section>
    <h1>Study</h1>

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
        <input type="button" value="リセット" onclick="location.href='/studies'; return false;" >
      </form>
    </section>

    <section>
      <h2>一覧</h2>
      <table>
        <thead>
          <tr>
            <th>ID.</th>
            <th>分類</th>
            <th>名前</th>
            <th colspan="2">進捗率</th>
            <th colspan="2">習得率</th>
            <th>リンク</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="sortdata">
          @foreach($studies as $study)
            <tr id="{{ $study->id }}">
              <td>{{ $study->id }}</td>
              <td>{{ $categories[$study->category_id] }}:{{ $varieties[$study->variety_id] }}</td>
              <td>{{ $study->name }}</td>
              <td>
                {{ $study->progress }}%
              </td>
              <td>
                <div style="background-color:blue; border-radius:5px; width:{{ $study->progress }}px">&nbsp;</div>
              </td>
              <td>{{ $study->mastery }}%</td>
              <td>
                <div style="background-color:blue; border-radius:5px; width:{{ $study->mastery }}px">&nbsp;</div>
              </td>
              <td>
                @if (!is_null($study->link))
                  <a href="{{ $study->link }}" target="_blank">関連</a>
                @endif
              </td>
              <td>
                <a href="/studies/{{ $study->id }}/edit">編集</a>
                <a href="/studies/{{ $study->id }}/indices">目次</a>
                <a href="/studies/{{ $study->id }}/problems">問題</a>
              </td>
            </tr>          
          @endforeach

        </tbody>
      </table>  
    </section>

    <section>
      <h2>新規登録フォーム</h2>
      <ul id="errors"></ul>
      <form id="create-form">
        <label for="create-category_id">カテゴリ</label>
        <x-forms.drop-box 
          id="create-category_id" 
          name="category_id" 
          hasEmpty="true" 
          :options="$categories"
        />
        <label for="createvariety_id">バラエティ</label>
        <x-forms.drop-box 
          id="create-variety_id" 
          name="variety_id" 
          hasEmpty="true" 
          :options="$varieties"
        />
        <label for="name">名称</label>
        <input name="name" type="text" value="">
        <input id="create" type="button" value="作成">
      </form>    
    </section>
  </section>
@endsection