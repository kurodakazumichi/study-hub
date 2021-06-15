@extends('layouts.default')

@section('title', 'StudyIndex')
@section('js', 'study_index/index.js')

@section('main')
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
        <td>{{ $index->major }}.{{ $index->minor }}.{{ $index->micro }}</td>
        <td>{{ $index->title }}</td>
        <td>{{ $index->mastery }}</td>
        <td>{{ $index->comment }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection