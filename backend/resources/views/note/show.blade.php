@extends('layouts.default')

@section('title', $note->title)
@section('js', 'note/show.js')

@section('main')
<article>
  <h1>{{ $note->title }}</h1>
  {{ $categories[$note->category_id] }}:{{ $varieties[$note->variety_id] }}
  {{ $note->created_at->format('Y/m/d') }}:{{ $note->updated_at->format('Y/m/d') }}
  <hr>
  {{ $note->body }}
</article>
@endsection