@extends('layouts.default')

@section('title', 'Achievement')
@section('js', 'achievement/index.js')

@section('main')
  
  <h1 class="heading-lv1">Achievement</h1>

  <section class="section">
    <div id="_tab">
      <ul>
        <li><a href="#_tab-search">検索</a></li>
        <li><a href="#_tab-form">フォーム</a></li>
      </ul>
      {{---------------------------------------- 検索フォーム ----------------------------------------}}
      <div id="_tab-search">
        <form action="/studies" method="get">
          <table class="table">
            <tbody>
              <tr>
                <th>カテゴリ</td>
                <td>
                  <x-forms.drop-box 
                    name="category_id" 
                    hasEmpty="true" 
                    :options="$categories"
                    :selected="$search['category_id']"
                  />
                </td>
                <th>バラエティ</th>
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
      </div>

      {{---------------------------------------- 入力フォーム ----------------------------------------}}
      <div id="_tab-form">
      <section>
    <h2 class="heading-lv2">新規登録フォーム</h2>
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

  <section class="section">
    <h2 class="heading-lv2">編集フォーム</h2>
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
      </div>
    </div>
  </section>

    




  <section class="section">
    <h2 class="heading-lv2">一覧</h2>

    @foreach($achievements as $achievement)

      <div class="achievement @empty($achievement->achievement_at) achievement--disabled @endempty">
        <div class="achievement__icon">
          <span class="trophy trophy--level{{ $achievement->difficulty }}"></span>
        </div>
        <div class="achievement__group">
          <span class="badge mb-3">{{ $categories[$achievement->category_id]}}</span><br>
          <span class="badge badge--sub">{{ $varieties[$achievement->variety_id ]}}</span>
        </div>
        <div class="achievement__contents">
          <h2 class="achievement__title">
            <span>#{{ $achievement->id}}.</span>
            @if (empty($achievement->note_id))
              {{ $achievement->title }}
            @else
              <a href="/notes/{{ $achievement->note_id }}/show">{{ $achievement->title }}</a>
            @endif            
          </h2>
          <p>
            {{ $achievement->condition }}
          </p>
        </div>
        <div class="achievement__info">
          <div>
            @isset($achievement->achievement_at)
              {{ (new DateTime($achievement->achievement_at))->format("Y.m.d") }}
            @else
              --
            @endisset
          </div>
          <div>
            @for($i = 0; $i < 5; $i++)
              @if ($i < $achievement->difficulty)
                <i class="fas fa-star" style="color:orange"></i>
              @else
                <i class="fas fa-star" style="color:gray"></i>
              @endif
            @endfor
          </div>          
        </div>
        <div class="achievement__ctrl">
          <button data-id="{{ $achievement->id }}" class="edit-button">編集</button>
          @if (empty($achievement->achievement_at))
            <button data-id="{{ $achievement->id }}" class="open-button">解放</button>
          @else
            <button data-id="{{ $achievement->id }}" class="close-button">取消</button>
          @endif
        </div>
      </div>

    @endforeach

  </section>


  
@endsection