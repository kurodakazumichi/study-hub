@extends('layouts.default')

@section('title', 'カテゴリ一覧')
@section('js', 'category/index.js')

@section('main')
  <h1>カテゴリ一覧</h1>

  <table>
    <thead>
      <tr>
        <th>ID.</th>
        <th>名称</th>
      </tr>
    </thead>
    <tbody id="sortdata">
      @foreach($categories as $category)
      <tr data-id="{{ $category->id }}" data-order-no="{{ $category->order_no }}">
        <td>{{ $category->id }}</td>
        <td><input class="category-name" data-id="{{ $category->id }}" type="text" value="{{ $category->name }}"></td>
      </tr>
      @endforeach
    </tbody>
  </table>

<form id="create-form">
  <label for="name">カテゴリ名</label>
  <input name="name" type="text" value="">
  <input id="create" type="button" value="作成">
</form>
@endsection