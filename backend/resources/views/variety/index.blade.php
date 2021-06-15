@extends('layouts.default')

@section('title', 'バラエティ一覧')
@section('js', 'variety/index.js')

@section('main')
  <h1>バラエティ一覧</h1>

  <table>
    <thead>
      <tr>
        <th>ID.</th>
        <th>名称</th>
      </tr>
    </thead>
    <tbody id="sortdata">
      @foreach($varieties as $variety)
      <tr data-id="{{ $variety->id }}" data-order-no="{{ $variety->order_no }}">
        <td>{{ $variety->id }}</td>
        <td><input class="variety-name" data-id="{{ $variety->id }}" type="text" value="{{ $variety->name }}"></td>
      </tr>
      @endforeach
    </tbody>
  </table>

<form id="create-form">
  <label for="name">バラエティ名</label>
  <input name="name" type="text" value="">
  <input id="create" type="button" value="作成">
</form>
@endsection