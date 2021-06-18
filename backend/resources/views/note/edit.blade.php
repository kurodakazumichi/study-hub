@extends('layouts.default')

@section('title', 'Note編集')
@section('js', 'note/edit.js')

@section('main')
  <section>
    <h1>Study</h1>
    <form id="edit-form">
      <input type="hidden" name="note_id" value={{ $note->id }}>
      <label for="search-category_id">カテゴリ</label>
      <x-forms.drop-box 
        id="search-category_id" 
        name="category_id" 
        :options="$categories"
        :selected="$note->category_id"
      />
        
      <label for="search-variety_id">バラエティ</label>
      <x-forms.drop-box 
        id="search-variety_id" 
        name="variety_id" 
        :options="$varieties"
        :selected="$note->variety_id"
      /><br>

      タイトル：<input type="text" name="title" size="100" value="{{ $note->title }}"><br>

      <textarea name="body" cols="100" rows="40">{{ $note->body }}</textarea>

      <input type="button" value="編集" id="edit-button">
    </form>
  </section>
@endsection