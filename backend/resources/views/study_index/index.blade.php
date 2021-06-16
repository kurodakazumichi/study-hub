@extends('layouts.default')

@section('title', $study->name)
@section('js', 'study_index/index.js')

@section('main')

<h1>{{ $study->name }}</h1>

<form id="create-form">
  <input type="hidden" name="id" value="{{ $study->id }}">
  <label for="create-index">Index</label>
  <input type="text" name="index" size="1" value="">
  <input type="text" name="title" size="64" value="">
  <input type="button" value="作成" id="create-button">
</form>

<form id="batch-form">
  <input type="hidden" name="id" value="{{ $study->id }}">
  <input type="file" name="file" value="ファイル送信" id="batch-file-button">
</form>

<table>
  <thead>
    <th>Index</th>
    <th>タイトル</th>
    <th>Mastery</th>
    <th>コメント</th>
  </thead>
  <tbody>
    @foreach($indices as $index)
      <tr>
        <td>
          {{ $index->major }}.
          @if(!is_null($index->minor)){{ $index->minor }}.@endif
          @if(!is_null($index->micro)){{ $index->micro }}.@endif
        </td>
        <td>{{ $index->title }}</td>
        <td>{{ $index->mastery }}</td>
        <td>{{ $index->comment }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection