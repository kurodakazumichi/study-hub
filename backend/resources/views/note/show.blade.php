@extends('layouts.default')

@section('title', $note->title)
@section('js', 'note/show.js')

@section('cdn')
  @include('shared.cdn.markdown', ['placefolder_id' => '#contents'])
@endsection

@section('main')

  <h1 class="heading-lv1 mb-10">
    <a class="col-white" href="/notes/{{ $note->id}}/edit">{{ $note->title }}</a>
  </h1>
  <div class="mb-20" style="display:flex; justify-content: space-between;">
    <div>
      <span class="badge">{{ $categories[$note->category_id] }}</span>
      <span class="badge badge--sub">{{ $varieties[$note->variety_id] }}</span>
    </div>        
    <div class="txt-righted" style="font-size:12px; font-family:monospace;">
      <span>created:{{ $note->created_at->format('Y/m/d') }}</span><br>
      <span>updated:{{ $note->updated_at->format('Y/m/d') }}</span>
    </div>    
  </div>

  <section id="contents" class="note">{!! $note->body !!}</section>

@endsection