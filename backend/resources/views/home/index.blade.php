@extends('layouts.default')
@section('title', 'status')

@section('main')
  <style>
  .power {
    background:white;
    text-align: center;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    font-size: 100px;
    letter-spacing: 0.2em;
  }
  </style>
  <h1 class="heading-lv1">Status</h1>

  <section class="section">
    <h2 class="heading-lv2">戦闘力</h2>
    <div class="power">{{ $power }}</div>
  </section>

  <section class="section">
    <h2 class="heading-lv2">Skill</h2>

    <table class="vertical-table">
      <thead class="vertical-table__header">
        <tr class="vertical-table__header-row">
          <th style="width:150px;">カテゴリ</th>
          <th style="width:100px;">スコア</th>
          <th>スコア</th>
        </tr>
      </thead>
      <tbody class="vertical-table__body">
        @foreach($skills as $skill)
          <tr>
            <td>{{ $categories[$skill->category_id] }}</td>
            <td>{{ $skill->score }}pt</td>
            <td>
              <div class="progress cur-pointer" style="width:100%px">
                <div class="progress__bar" style="width:{{ $skill->rate }}%;">&nbsp;</div>
                <div class="progress__text">{{ $skill->score }}</div>
              </div> 
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>

  <section class="section">
    <h2 class="heading-lv2">Achievement</h2>

    <table class="vertical-table">
      <thead class="vertical-table__header">
        <tr class="vertical-table__header-row">
          <th style="width:120px;">カテゴリ</th>
          <th style="width:100px;">件数</th>
          <th style="width:100px;">スコア</th>
          <th>達成率</th>
        </tr>
      </thead>
      <tbody class="vertical-table__body">
        @foreach($achievements as $achieve) 

          <tr>
            <td>{{ $categories[$achieve->category_id] }}</td>
            <td class="txt-centered">{{ $achieve->cleared }}/{{ $achieve->count}}件</td>
            <td>{{ $achieve->score }}pt</td>
            <td>
              <div class="progress cur-pointer" style="width:100%px">
                <div class="progress__bar" style="width:{{ $achieve->progress }}%;">&nbsp;</div>
                <div class="progress__text">{{ $achieve->progress }}%</div>
              </div> 
            </td>
            
          </tr>

        @endforeach
      </tbody>
    </table>


  </section>  
@endsection