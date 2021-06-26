@extends('layouts.default')

@section('title', 'Note新規作成')
@section('js', 'note/create.js')

@section('main')
  
    <h1 class="heading-lv1">Note</h1>
    <form id="create-form">

      <table class="table w-100">
        <tbody>
          <tr>
            <th style="width:10%;">カテゴリ</th>
            <td style="width:40%;">
              <x-forms.drop-box 
                id="search-category_id" 
                name="category_id" 
                :options="$categories"
              />
            </td>
            <th style="width:10%;">バラエティ</th>
            <td style="width:40%;">
              <x-forms.drop-box 
                id="search-variety_id" 
                name="variety_id" 
                :options="$varieties"
              />
            </td>
          </tr>
          <tr>
            <th>タイトル</th>
            <td colspan="3">
              <input type="text" name="title" class="w-100"><br>
            </td>
          </tr>
          <tr>
            <td colspan="4" style="padding:0; border:none;">
              <textarea class="w-100" name="body" rows="40"></textarea>
            </td>
          </tr>
        </tbody>
      </table>

      <input type="button" value="新規作成" id="create-button">
    </form>
  
@endsection