@extends('layouts.default')

@section('title', 'バラエティ一覧')
@section('js', 'variety/index.js')

@section('main')
  <h1 class="heading-lv1">バラエティ一覧</h1>

  <table class="vertical-table">
    <thead class="vertical-table__header">
      <tr class="vertical-table__header-row">
        <th>ID.</th>
        <th>名称</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody id="sortdata" class="vertical-table__body">
      @foreach($varieties as $variety)
      <tr data-id="{{ $variety->id }}" data-order-no="{{ $variety->order_no }}">
        <td>{{ $variety->id }}</td>
        <td><input class="variety-name" data-id="{{ $variety->id }}" type="text" value="{{ $variety->name }}"></td>
        <td class="hp_txtCentered">
          <a href="#" data-id="{{ $variety->id }}" class="btn delete">削除</a>
        </td>        
      </tr>
      @endforeach
    </tbody>
    <tbody class="vertical-table__body">
      <tr id="_create-form">
        <td>&nbsp;</td>
        <td class="hp_txtCentered">
          <input name="name" type="text" value="">
        </td>        
        <td class="hp_txtCentered">
          <a name="submit" href="#" data-id="{{ $variety->id }}" class="btn btn--save">作成</a>
        </td>
      </tr>
    </tbody>
  </table>
@endsection