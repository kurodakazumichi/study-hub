@extends('layouts.default')

@section('title', 'Study')
@section('js', 'study/index.js')

@section('main')
  <section>
    <h1>Study</h1>

    <section>
      <h2>検索フォーム</h2>
      <form action="/studies" method="get">
        <label for="search-category_id">カテゴリ</label>
        <x-forms.drop-box 
          id="search-category_id" 
          name="category_id" 
          hasEmpty="true" 
          :options="$categories"
          :selected="2"
        />
        
        <label for="search-variety_id">バラエティ</label>
        <x-forms.drop-box id="search-variety_id" name="variety_id" hasEmpty="true" :options="$varieties"/>

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
        <label for="create-category_id">カテゴリ</label>
        <x-forms.drop-box 
          id="create-category_id" 
          name="category_id" 
          hasEmpty="true" 
          :options="$categories"
        />
        <label for="createvariety_id">バラエティ</label>
        <x-forms.drop-box 
          id="create-variety_id" 
          name="variety_id" 
          hasEmpty="true" 
          :options="$varieties"
        />
        <label for="name">名称</label>
        <input name="name" type="text" value="">
        <input id="create" type="button" value="作成">
      </form>    
    </section>
  </section>
@endsection