@extends('layouts.default')

@section('title', 'Study編集')
@section('js', 'study/edit.js')

@section('main')
  <section>
    <h1>Study編集</h1>
    <a href="/studies">戻る</a>
    <section>
      <h2>編集フォーム</h2>
      <ul id="errors"></ul>
      <form id="edit-form">
        <input type="hidden" name="id" value="{{ $study->id }}" >
        <span>ID:{{$study->id}}</span><br>
        <label for="edit-category_id">カテゴリ</label>
        <x-forms.drop-box 
          id="create-category_id" 
          name="category_id" 
          hasEmpty="true"
          :options="$categories"
          :selected="$study->category_id"
        />
        <label for="edit-variety_id">バラエティ</label>
        <x-forms.drop-box 
          id="edit-variety_id" 
          name="variety_id" 
          hasEmpty="true" 
          :options="$varieties"
          :selected="$study->variety_id"
        />
        <label for="name">名称</label>
        <input name="name" type="text" size="50" value="{{ $study->name }}"><br>

        <label for="link">リンク</label>
        <input type="text" name="link" size="50" value="{{ $study->link }}"><br>
        <input id="create" type="button" value="編集">
      </form>    
    </section>    
  </section>
@endsection