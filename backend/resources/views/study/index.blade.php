@extends('layouts.default')

@section('title', 'Study')
@section('js', 'study/index.js')

@section('main')
    <h1 class="heading-lv1">Study</h1>

    <div class="section">
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
        </div>

        {{---------------------------------------- 入力フォーム ----------------------------------------}}
        <div id="_tab-form">
          <table class="table mb-10">
            <tbody>
              <tr>
                <th style="width:100px;">ID</th>
                <td>
                  <input type="hidden" name="id">
                  <span class="_text-id">新規</span>
                </td>

                <th>カテゴリ</th>
                <td>
                  <x-forms.drop-box 
                    name="category_id" 
                    hasEmpty="true" 
                    :options="$categories"
                  />
                </td>

                <th>バラエティ</th>
                <td>
                  <x-forms.drop-box 
                    name="variety_id" 
                    hasEmpty="true" 
                    :options="$varieties"
                  />
                </td>
                
                <th>表示優先度</th>
                <td>
                  <input type="text" name="order_no" size="2">
                </td>

                <th>ノートID</th>
                <td>
                  <input type="text" name="note_id"size="2">
                  <a class="before-icon before-icon--note _lnk-note" href="#">ノートを作る</a>
                </td>                               
              </tr>

              <tr>
                <th>タイトル</th>
                <td colspan="9">
                  <input class="w-100" name="name" type="text" value="">
                </td>
              </tr>

              <tr>
                <th>リンク</th>
                <td colspan="9">
                  <input class="w-100" type="text" name="link">
                </td>
              </tr>
              
            </tbody>
          </table>
          
          <div class="txt-righted">
            <a class="btn btn--save _btn-save" href="#">保存</a>
          </div>
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
            <th>名前</th>
            <th>進捗率</th>
            <th>習得率</th>
            <th style="width:75.95px">リンク</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody class="vertical-table__body">
          @foreach($studies as $study)
            <tr id="{{ $study->id }}">
              <td>{{ $study->id }}</td>
              <td>
                <span class="badge mb-3">{{ $categories[$study->category_id] }}</span><br>
                <span class="badge badge--sub">{{ $varieties[$study->variety_id] }}</span>
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
                <a title="目次" class="mr-3" href="/studies/{{ $study->id }}/indices">
                  <i class="fas fa-list"></i>
                </a>

                <a title="問題" class="mr-3" href="/studies/{{ $study->id }}/problems">
                  <i class="fas fa-question"></i>
                </a>

                @if (!is_null($study->link))
                  <a title="関連リンク" href="{{ $study->link }}" target="_blank">
                    <i class="fas fa-link"></i>
                  </a>
                @endif
              </td>
              <td  class="txt-centered">
                <a title="編集" href="/studies/{{ $study->id }}/edit"><i class="fas fa-edit"></i></a>
              </td>
            </tr>          
          @endforeach

        </tbody>
      </table>  
    </section>

@endsection