@extends('layouts.default')

@section('title', 'カテゴリ一覧')
@section('js', 'category/index.js')

@section('main')

  <h1 class="heading-lv1">カテゴリ一覧</span>
  </h1>

  <table class="vertical-table">
    <thead class="vertical-table__header">
      <tr class="vertical-table__header-row">
        <th>#</th>
        <th>名称</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody id="_sortable" class="vertical-table__body">
      @foreach($categories as $category)
      <tr id="{{ $category->id }}" data-order-no="{{ $category->order_no }}">
        <td>{{ $category->id }}</td>
        <td><input data-id="{{ $category->id }}" class="name" type="text" value="{{ $category->name }}"></td>
        <td class="txt-centered">
          <a href="#" data-id="{{ $category->id }}" class="btn _delete">削除</a>
        </td>
      </tr>
      @endforeach
    </tbody>
    <tbody class="vertical-table__body">
      <tr id="_create-form">
        <td>&nbsp;</td>
        <td>
          <input name="name" type="text" value="">
        </td>
        <td class="txt-centered">
          <a name="submit" href="#" data-id="{{ $category->id }}" class="btn btn--save">作成</a>
        </td>
      </tr>    
    </tbody>
  </table>

  <div id="_notice" style="display:none; position:fixed; top:1em; width:1200px;">
    <ul class="alerts">
    </ul>
  </div>

@endsection