@extends('layouts.default')

@section('title', 'Study')
@section('js', 'study/index.js')

@section('main')
    <h1 class="heading-lv1">Study</h1>

    <section class="section">
      <h2 class="heading-lv2">検索フォーム</h2>
      <form action="/studies" method="get">
        <table>
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
                <input class="btn" type="button" value="リセット" onclick="location.href='/studies'; return false;" >
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </section>

    <section class="section">
      <h2 class="heading-lv2">一覧</h2>
      <table class="vertical-table">
        <thead class="vertical-table__header">
          <tr class="vertical-table__header-row">
            <th>ID.</th>
            <th colspan="2">分類</th>
            <th>名前</th>
            <th>進捗率</th>
            <th>習得率</th>
            <th>リンク</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="sortdata" class="vertical-table__body">
          @foreach($studies as $study)
            <tr id="{{ $study->id }}">
              <td>{{ $study->id }}</td>
              <td>
                <span class="badge">{{ $categories[$study->category_id] }}</span>
              </td>
              <td>
                <span class="badge">{{ $varieties[$study->variety_id] }}</span>
              </td>
              <td>
                @if (empty($study->note_id))
                  {{ $study->name }}
                @else
                  <a href="/notes/{{ $study->note_id }}/show">{{ $study->name }}</a>  
                @endif
              </td>
              <td>
                <div class="progress" style="width:75px">
                  <div class="progress__bar" style="width:{{ $study->progress }}%">&nbsp;</div>
                  <div class="progress__text">{{ $study->progress }}%</div>
                </div>                
              </td>
              <td>
                <div class="progress" style="width:75px">
                  <div class="progress__bar" style="width:{{ $study->mastery }}%">&nbsp;</div>
                  <div class="progress__text">{{ $study->mastery }}%</div>
                </div>                   
              </td>
              <td>
                <a 
                  class="before-icon before-icon--list"
                  href="/studies/{{ $study->id }}/indices">目次</a>&nbsp;

                <a
                  class="before-icon before-icon--question"
                  href="/studies/{{ $study->id }}/problems">問題</a>&nbsp;       
                       
                @if (!is_null($study->link))
                  <a 
                    class="before-icon before-icon--link" 
                    href="{{ $study->link }}" target="_blank">関連</a>
                @endif
              </td>
              <td>
                <a 
                  class="before-icon before-icon--edit" 
                  href="/studies/{{ $study->id }}/edit">編集</a>&nbsp;


              </td>
            </tr>          
          @endforeach

        </tbody>
      </table>  
    </section>

    <section class="section">
      <h2 class="heading-lv2">新規登録フォーム</h2>
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
        <input class="btn btn--save" id="create" type="button" value="作成">
      </form>    
    </section>

@endsection