@extends('layouts.default')

@section('title', $study->name)
@section('js', 'study_index/index.js')

@section('main')
<style>
#edit-container {
  position: fixed;
  bottom: 0;
  background-color: #dad8da;
  padding: 10px;
  width: 100%;
  z-index: 100;
}

#_mastery-view {
  position:absolute;
  width:24px;  
  font-size:12px; 
  background:#FFE600; 
  text-align:center; 
  padding:.05em .2em;
  border:1px solid #ddd;
  border-radius: 3px;
}
.input-no {
  width:20px
}

.input-no::-webkit-inner-spin-button,
.input-no::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    -moz-appearance:textfield;
}
</style>
<h1 class="heading-lv1">{{ $study->name }}</h1>

@if(count($stats) !== 0)
  <section class="section">
    <h2 class="heading-lv2">Stats</h2>
    <table class="vertical-table">
      <thead class="vertical-table__header">
        <tr class="vertical-table__header-row">
          <th style="width:100px">件数</th>
          <th>進捗率</th>
          <th>習得率</th>
        </tr>
      </thead>
      <tbody class="vertical-table__body">
        @foreach($stats as $stat)
        <tr>
          <td class="txt-centered">{{ $stat->done_count }}/{{ $stat->count }}件</td>
          <td>
            <div class="progress cur-pointer" style="width:100%px">
              <div class="progress__bar" style="width:{{ $stat->progress }}%;">&nbsp;</div>
              <div class="progress__text">{{ $stat->progress }}%</div>
            </div> 
          </td>
          <td>
            <div class="progress cur-pointer" style="width:100%px">
              <div class="progress__bar" style="width:{{ $stat->mastery }}%;">&nbsp;</div>
              <div class="progress__text">{{ $stat->mastery }}%</div>
            </div> 
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>
@endif

<section class="section">

<h2 class="heading-lv2">検索フォーム</h2>
  <form action="/studies/{{ $study->id }}/indices" method="get">

    <x-forms.drop-box 
      id="" name="mastery" :options="App\Consts\StudyProblemConsts::MASTERIES"
      :hasEmpty="true"
      :selected="$search['mastery']"
    />

    No:
    <input type="number" name="major_min" value="{{ $search['major_min']}}" class="input-no">.
    <input type="number" name="minor_min" value="{{ $search['minor_min']}}" class="input-no">
    ～
    <input type="number" name="major_max" value="{{ $search['major_max']}}" class="input-no">.
    <input type="number" name="minor_max" value="{{ $search['minor_max']}}" class="input-no">

    <input name="random" type="checkbox" @if($search['random']) checked @endif>:ランダム
    <input type="submit" value="検索">
  </form>

  <h2 class="heading-lv2">新規フォーム</h2>
  <form id="create-form">
    <input type="hidden" name="index_id">
    <input type="hidden" name="study_id" value="{{ $study->id }}">
    <label for="create-index">Index</label>
    <input type="text" name="index" size="1" value="">
    <input type="text" name="title" size="64" value="">
    <input type="button" value="作成" id="create-button">
  </form>

  <h2 class="heading-lv2">CSV一括登録</h2>
  <form id="batch-form">
    <input type="hidden" name="id" value="{{ $study->id }}">
    <input type="file" name="file" value="ファイル送信" id="batch-file-button">
  </form>  
</section>

<div id="edit-container">
  <h2 class="heading-lv2">編集フォーム</h2>
  <form id="edit-form">
    <input type="hidden" name="id">
    Index:<input type="text" name="index"><br>
    title:<input type="text" name="title"><br>
    mastery:<x-forms.drop-box 
      id="" name="mastery" :options="App\Consts\StudyIndexConsts::MASTERIES"
    /><br>
    コメント：<br>
    <textarea name="comment" id="" cols="100" rows="4"></textarea><br>
    
    リンク：<input type="text" name="link" size="50"><br>
    ノートID：<input type="text" name="note_id" size="2"><br>
    <input type="button" value="更新" id="edit-button">
  </form>
</div>

<h2 class="heading-lv2">目次</h2>
<table class="vertical-table">
  <thead class="vertical-table__header">
    <tr class="vertical-table__header-row">
      <th style="width:82px">Index</th>
      <th>タイトル</th>
      <th style="width:400px;">コメント</th>
      <th style="width:96px;">Mastery</th>      
      <th style="width:42.88px">&nbsp;</th>
      <th style="width:42.88px">&nbsp;</th>
    </tr>
  </thead>
  <tbody class="vertical-table__body">
    @foreach($indices as $index)
      <tr>
        <td>
          @if(is_null($index->minor) && is_null($index->micro))
            {{$index->major}}
          @endif
          @if(!is_null($index->minor) && is_null($index->micro))
            {{$index->major}}.{{$index->minor}}
          @endif          
          @if(!is_null($index->minor) && !is_null($index->micro))
            {{$index->major}}.{{$index->minor}}.{{$index->micro}}
          @endif
        </td>
        <td>
          @if(is_null($index->minor) && is_null($index->micro))
            <span style="font-size:16px; font-weight:bold; color:#32978B;">{{ $index->title }}</span>
          @endif
          @if(!is_null($index->minor) && is_null($index->micro))
            <span style="font-size:14px; font-weight:bold">{{ $index->title }}</span>
          @endif          
          @if(!is_null($index->minor) && !is_null($index->micro))
            <span style="font-size:12px;">{{ $index->title }}</span>
          @endif

          @if (!empty($index->link))
            <a href="{{$index->link}}" target="_blank">
              <i class="fas fa-link"></i>
            </a>
          @endif          
        </td>
        <td>
          <span style="font-size:.75em;">
            {!! nl2br($index->comment) !!}
          </span>
        </td>
        <td>
          <div class="progress cur-pointer" style="width:75px" data-id="{{ $index->id }}" data-study_id="{{ $study->id }}">
            <div class="progress__bar" style="width:{{ $index->mastery * 10 }}%; pointer-events:none;">&nbsp;</div>
            <div class="progress__text" style="pointer-events:none;">{{ \App\Consts\StudyIndexConsts::MASTERIES[$index->mastery] }}</div>
          </div>          
        </td>
        <td class="txt-centered">
          @if (!empty($index->note_id))
            <a
              class="before-icon before-icon--note" 
              href="/notes/{{ $index->note_id }}/show"></a>
          @else
            <a 
              href="#"
              data-id="{{ $index->id }}"
              class="before-icon before-icon--plus-circle _make-note"></a>
          @endif
        </td>
        <td class="txt-centered">
          <a href="#">
            <i data-id="{{ $index->id }}" class="fas fa-edit edit-button"></i>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div id="_mastery-view"></div>
@endsection