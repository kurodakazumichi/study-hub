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

</style>
<h1>{{ $study->name }}</h1>

<h2>新規フォーム</h2>
<form id="create-form">
  <input type="hidden" name="index_id">
  <input type="hidden" name="study_id" value="{{ $study->id }}">
  <label for="create-index">Index</label>
  <input type="text" name="index" size="1" value="">
  <input type="text" name="title" size="64" value="">
  <input type="button" value="作成" id="create-button">
</form>

<div id="edit-container">
  <h2>編集フォーム</h2>
  <form id="edit-form">
    <input type="hidden" name="id">
    Index:<input type="text" name="index"><br>
    title:<input type="text" name="title"><br>
    mastery:<x-forms.drop-box 
      id="" name="mastery" :options="App\Consts\StudyIndexConsts::MASTERIES"
    /><br>
    コメント：<input type="text" name="comment">
    <input type="button" value="更新" id="edit-button">
  </form>
</div>

<h2>CSV一括登録</h2>
<form id="batch-form">
  <input type="hidden" name="id" value="{{ $study->id }}">
  <input type="file" name="file" value="ファイル送信" id="batch-file-button">
</form>

<h2>目次</h2>
<table>
  <thead>
    <th>Index</th>
    <th>タイトル</th>
    <th colspan="2">Mastery</th>
    <th>コメント</th>
    <th>操作</th>
  </thead>
  <tbody>
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
          {{ \App\Consts\StudyIndexConsts::MASTERIES[$index->mastery] }}
        </td>
        <td>
          <div style="background-color:blue; border-radius:3px; width:{{ $index->mastery * 10 }}px;">&nbsp</div>
        </td>
        <td>{{ $index->comment }}</td>
        <td>
          <button data-id="{{ $index->id }}" class="edit-button">編集</button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection