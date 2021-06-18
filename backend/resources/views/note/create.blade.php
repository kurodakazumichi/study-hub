@extends('layouts.default')

@section('title', 'Note新規作成')
@section('js', 'note/create.js')

@section('main')
  <section>
    <h1>Study</h1>
    <form id="create-form">
      <label for="search-category_id">カテゴリ</label>
      <x-forms.drop-box 
        id="search-category_id" 
        name="category_id" 
        :options="$categories"
      />
        
      <label for="search-variety_id">バラエティ</label>
      <x-forms.drop-box 
        id="search-variety_id" 
        name="variety_id" 
        :options="$varieties"
      /><br>

      タイトル：<input type="text" name="title" size="100"><br>

      <textarea name="body" cols="100" rows="40"></textarea>

      <input type="button" value="新規作成" id="create-button">
    </form>
  </section>
@endsection