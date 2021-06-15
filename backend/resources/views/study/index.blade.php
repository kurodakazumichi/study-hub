@extends('layouts.default')

@section('title', 'Study')
@section('js', 'study/index.js')

@section('main')
  <section>
    <h1>Study</h1>

    <section>
      <h2>検索フォーム</h2>
      <form action="/studies" method="get">
        <label for="category_id">カテゴリ</label>
        <select name="category_id" id="">
          <option value="">なし</option>
          <option value="1">数学</option>
        </select>
        <label for="variety_id">バラエティ</label>
        <select name="variety_id" id="">
          <option value="">なし</option>
          <option value="1">数学</option>
        </select>
        <input type="submit" value="検索">
      </form>
    </section>

    <section>
      <h2>一覧</h2>
      <table>
        <thead>
          <tr>
            <th>ID.</th>
            <th>分類</th>
            <th>名前</th>
            <th>作成日</th>
            <th>更新日</th>
          </tr>
        </thead>
        <tbody id="sortdata">
          <tr>
            <td>1</td>
            <td>数学:数Ⅱ+B</td>
            <td>チャート式 基礎を演習 数学Ⅱ+B</td>
            <td>2021年6月15日</td>
            <td>2021年6月15日</td>
          </tr>
        </tbody>
      </table>  
    </section>

    <section>
      <h2>新規登録フォーム</h2>
      <ul id="errors"></ul>
      <form id="create-form">
        <label for="category_id">カテゴリ</label>
        <select name="category_id" id="">
          <option value="">なし</option>
          <option value="1">数学</option>
          <option value="100">hoge</option>
        </select>
        <label for="variety_id">バラエティ</label>
        <select name="variety_id" id="">
          <option value="">なし</option>
          <option value="1">数学</option>
          <option value="100">hoge</option>
        </select>
        <label for="name">名称</label>
        <input name="name" type="text" value="">
        <input id="create" type="button" value="作成">
      </form>    
    </section>
  </section>
@endsection