@extends('layouts.default')

@section('title', 'カテゴリ一覧')
@section('js', 'category/index.js')

@section('main')
  <h1 class="el_h5">カテゴリ一覧</h1>

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
      <tr id="{{ $category->id }}" data-order-no="{{ $category->order_no }}">
        <td>{{ $category->id }}</td>
        <td><input class="category-name" data-id="{{ $category->id }}" type="text" value="{{ $category->name }}"></td>
        <td class="hp_txtCentered">
          <a href="#" data-id="{{ $category->id }}" class="el_btn delete">削除</a>
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
        <td class="hp_txtCentered">
          <a name="submit" href="#" data-id="{{ $category->id }}" class="el_btn el_btn__save">作成</a>
        </td>
      </tr>    
    </tbody>
  </table>

<div id="errors">errors</div>
@endsection