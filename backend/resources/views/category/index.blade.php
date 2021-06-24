@extends('layouts.default')

@section('title', 'カテゴリ一覧')
@section('js', 'category/index.js')

@section('main')

<div style="display:none">
<a href="#" class="before-icon-btn before-icon-btn--download">ボタン</a>
<a href="#" class="before-icon-btn before-icon-btn--zoom">ボタン</a>
<a href="#" class="before-icon before-icon--pdf">ファイル名.pdf</a>
<span class="before-icon before-icon--excel">Excel</span>
<span class="before-icon before-icon--point">Excel</span>
<span class="before-icon before-icon--square">Excel</span>
<span class="before-icon before-icon--chevron-left">Excel</span>
<span class="after-icon after-icon--chevron-right">Excel</span>
<span class="label">数学</span>
<span class="label label--warning">数A</span>
<span class="rounded-label">数学</span>
<strong class="caution-text">※注釈が入ります</strong>

<div class="media media--reverse">
  <figure class="media__img-wrapper">
    <img class="media__img" src="https://cho-animedia.jp/imgs/p/4i9dnYHcCN43tBa-eYkdtFrMc8LMwsPExcbH/165330.jpg" alt="ロキシー">
  </figure>
  <div class="media__body">
    <h3 class="media__title">ロキシー・ミグルディア</h3>
    <p class="media__text">
      魔族「ミグルド族」の魔術師。外見は青髪を三つ編みにした眠たげな目の少女。人族より長命な種族なので、外見年齢は14歳だが[34]、初登場時で既に37歳。
    </p>
  </div>
</div>


<a href="#" class="label label--link">ほげ</a>
</div>

  <h1 class="heading-lv1">カテゴリ一覧</h1>

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

@endsection