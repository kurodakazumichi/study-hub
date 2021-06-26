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

</style>
<h1 class="heading-lv1">{{ $study->name }}</h1>

<h2 class="heading-lv2">新規フォーム</h2>
<form id="create-form">
  <input type="hidden" name="index_id">
  <input type="hidden" name="study_id" value="{{ $study->id }}">
  <label for="create-index">Index</label>
  <input type="text" name="index" size="1" value="">
  <input type="text" name="title" size="64" value="">
  <input type="button" value="作成" id="create-button">
</form>

<div id="edit-container">
  <h2 class="heading-lv2">編集フォーム</h2>
  <form id="edit-form">
    <input type="hidden" name="id">
    Index:<input type="text" name="index"><br>
    title:<input type="text" name="title"><br>
    mastery:<x-forms.drop-box 
      id="" name="mastery" :options="App\Consts\StudyIndexConsts::MASTERIES"
    /><br>
    コメント：<input type="text" name="comment"><br>
    リンク：<input type="text" name="link" size="50"><br>
    ノートID：<input type="text" name="note_id" size="2"><br>
    <input type="button" value="更新" id="edit-button">
  </form>
</div>

<h2 class="heading-lv2">CSV一括登録</h2>
<form id="batch-form">
  <input type="hidden" name="id" value="{{ $study->id }}">
  <input type="file" name="file" value="ファイル送信" id="batch-file-button">
</form>

<h2 class="heading-lv2">目次</h2>
<table class="vertical-table">
  <thead class="vertical-table__header">
    <tr class="vertical-table__header-row">
      <th>Index</th>
      <th>タイトル</th>
      <th>Mastery</th>
      <th>コメント</th>
      <th>ノート</th>
      <th>操作</th>
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
            <span style="font-size:16px; font-weight:bold;">{{ $index->title }}</span>
          @endif
          @if(!is_null($index->minor) && is_null($index->micro))
            <span style="font-size:14px;">{{ $index->title }}</span>
          @endif          
          @if(!is_null($index->minor) && !is_null($index->micro))
            <span style="font-size:12px;">{{ $index->title }}</span>
          @endif

        </td>
        <td>
          <div class="progress cur-pointer" style="width:75px" data-id="{{ $index->id }}" data-study_id="{{ $study->id }}">
            <div class="progress__bar" style="width:{{ $index->mastery * 10 }}%; pointer-events:none;">&nbsp;</div>
            <div class="progress__text" style="pointer-events:none;">{{ \App\Consts\StudyIndexConsts::MASTERIES[$index->mastery] }}</div>
          </div>          
        </td>
        <td>{{ $index->comment }}</td>
        <td class="txt-centered">
          @if (!empty($index->note_id))
            <a
              class="before-icon before-icon--note" 
              href="/notes/{{ $index->note_id }}/show"></a>
          @endif        
          @if (!empty($index->link))
            <a href="{{$index->link}}" target="_blank">関連</a>
          @endif
        </td>
        <td>
          <button data-id="{{ $index->id }}" class="edit-button">編集</button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div id="_mastery-view"></div>
@endsection