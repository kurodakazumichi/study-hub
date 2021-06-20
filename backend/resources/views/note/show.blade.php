@extends('layouts.default')

@section('title', $note->title)
@section('js', 'note/show.js')

@section('cdn')
  @include('shared.cdn.markdown', ['placefolder_id' => '#contents'])
@endsection

@section('main')
<article>
  <h1>{{ $note->title }}</h1>
  {{ $categories[$note->category_id] }}:{{ $varieties[$note->variety_id] }}
  {{ $note->created_at->format('Y/m/d') }}:{{ $note->updated_at->format('Y/m/d') }}
  <hr>
  <section id="contents" class="note">{{ $note->body }}</section>
  <a href="/notes/{{ $note->id}}/edit">編集</a>
</article>
@endsection