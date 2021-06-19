@extends('layouts.default')

@section('title', 'Achievement')
@section('js', 'achievement/index.js')

@section('main')
  <section>
    <h1>Achievement</h1>
@php /*
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
*/
@endphp
    <section>
      <h2>一覧</h2>
      <table>
        <thead>
          <tr>
            <th>ID.</th>
            <th>分類</th>
            <th>タイトル</th>
            <th>解放条件</th>
            <th>難易度</th>
            <th>解放日</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody id="sortdata">
          @foreach($achievements as $achievement)
            <tr>
              <td>{{ $achievement->id }}</td>
              <td>
                {{ $categories[$achievement->category_id]}}:{{ $varieties[$achievement->variety_id ]}}
              </td>
              <td>
                @if (empty($achievement->note_id))
                  {{ $achievement->title }}
                @else
                  <a href="/notes/{{ $achievement->note_id }}/show">{{ $achievement->title }}</a>
                @endif
              </td>
              <td>{{ $achievement->condition }}</td>
              <td>
                @for($i = 0; $i < 5; $i++)
                  @if ($i < $achievement->difficulty)
                    <span style="color:orange">★</span>
                  @else
                    <span style="color:gray">★</span>
                  @endif
                @endfor
              </td>
              <td>
                @isset($achievement->achievement_at)
                  {{ (new DateTime($achievement->achievement_at))->format("Y.m.d") }}
                @endisset
              </td>
              <td>
                <button data-id="{{ $achievement->id }}" class="edit-button">編集</button>
                @if (empty($achievement->achievement_at))
                  <button data-id="{{ $achievement->id }}" class="open-button">解放</button>
                @else
                  <button data-id="{{ $achievement->id }}" class="close-button">取消</button>
                @endif
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
          :options="$categories"
        />
        <label for="createvariety_id">バラエティ</label>
        <x-forms.drop-box 
          id="create-variety_id" 
          name="variety_id" 
          :options="$varieties"
        />

        <label for="">難易度</label>
        <x-forms.drop-box 
          id="create-diificulty" 
          name="difficulty" 
          :options="App\Consts\AchievementConsts::DIFFICULTIES"
        />
        <label for="title">タイトル</label>
        <input name="title" type="text" value="" size="50">

        <br>

        <label for="name">条件</label>
        <textarea name="condition" id="" cols="30" rows="10"></textarea>

        <input id="create" type="button" value="作成">
      </form>    
    </section>

    <section>
      <h2>編集フォーム</h2>
      <ul id="errors"></ul>
      <form id="edit-form">
        <input type="hidden" name="id">
        <label for="create-category_id">カテゴリ</label>
        <x-forms.drop-box 
          name="category_id" 
          :options="$categories"
        />
        <label for="createvariety_id">バラエティ</label>
        <x-forms.drop-box 
          name="variety_id" 
          :options="$varieties"
        />

        <label for="">難易度</label>
        <x-forms.drop-box 
          name="difficulty" 
          :options="App\Consts\AchievementConsts::DIFFICULTIES"
        />
        <label for="title">タイトル</label>
        <input name="title" type="text" value="" size="50">

        <br>

        <label for="">ノートID</label>
        <input type="text" name="note_id"><br>

        <label for="name">条件</label>
        <textarea name="condition" id="" cols="30" rows="10"></textarea>

        <input id="edit" type="button" value="編集">
      </form>    
    </section>    
  </section>
@endsection