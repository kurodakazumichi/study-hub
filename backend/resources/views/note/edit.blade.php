@extends('layouts.default')

@section('title', 'Note編集')
@section('js', 'note/edit.js')

@section('cdn')
  @include('shared.cdn.markdown')
@endsection


@section('main')

  <h1 class="heading-lv1">Note Edit</h1>

  <div id="_tab">
    <ul>
      <li><a href="#_tab-editor">エディタ</a></li>
      <li><a href="#_tab-preview">プレビュー</a></li>
    </ul>
    <div id="_tab-editor">
      <form id="edit-form">
        <input type="hidden" name="note_id" value={{ $note->id }}>
          <table class="table w-100">
            <tbody>
              <tr>
                <th style="width:10%;">カテゴリ</th>
                <td style="width:40%;">
                  <x-forms.drop-box 
                    id="search-category_id" 
                    name="category_id" 
                    :options="$categories"
                    :selected="$note->category_id"
                  />
                </td>
                <th style="width:10%;">バラエティ</th>
                <td style="width:40%;">
                  <x-forms.drop-box 
                    id="search-variety_id" 
                    name="variety_id" 
                    :options="$varieties"
                    :selected="$note->variety_id"
                  />
                </td>
              </tr>
              <tr>
                <th>タイトル</th>
                <td colspan="3">
                  <input type="text" name="title" class="w-100" value="{{ $note->title }}"><br>
                </td>
              </tr>
              <tr>
                <td colspan="4" style="padding:0; border:none;">
                  <textarea class="w-100" name="body"cols="100" rows="40">{{ $note->body }}</textarea>
                </td>
              </tr>
            </tbody>
          </table>
        <input type="button" value="編集" id="edit-button">
      </form>
    </div>
    <div id="_tab-preview">
      <div id="_view" class="note"></div>
    </div>
  </div>


@endsection