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
        <th>操作</th>
      </tr>
    </thead>
    <tbody id="sortdata">
      @foreach($categories as $category)
      <tr data-id="{{ $category->id }}" data-order-no="{{ $category->order_no }}">
        <td>{{ $category->id }}</td>
        <td><input class="category-name" data-id="{{ $category->id }}" type="text" value="{{ $category->name }}"></td>
        <td>
          <button data-id="{{ $category->id }}" class="delete">削除</button>
        </td>
      </tr>
      @endforeach
    </tbody>
    <tbody>
      <tr id="create-form">
        <td>&nbsp;</td>
        <td>
          <input name="name" type="text" value="">
        </td>
        <td>
          <button name="submit">作成</button>
        </td>
      </tr>    
    </tbody>
  </table>

<div id="errors">errors</div>
@endsection