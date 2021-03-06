@extends('layouts.default')

@section('title', $study->name)
@section('js', 'study_problem/index.js')

@section('cdn')
  @include('shared.cdn.markdown')
@endsection

@section('main')
<style>
#edit-container {
  position: fixed;
  bottom: 0;
  background-color: #dad8da;
  padding: 10px;
  width: 100%;
}

mjx-container {
  font-size:.75em;
}

.input-no {
  width:20px
}

.input-no::-webkit-inner-spin-button,
.input-no::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    -moz-appearance:textfield;
}

</style>
<h1 class="heading-lv1">{{ $study->name }}</h1>

@if(count($stats) !== 0)
  <section class="section">
    <h2 class="heading-lv2">Stats</h2>
    <table class="vertical-table">
      <thead class="vertical-table__header">
        <tr class="vertical-table__header-row">
          <th style="width:100px;">種別</th>
          <th style="width:60px;">件数</th>
          <th>進捗率</th>
          <th>習得率</th>
        </tr>
      </thead>
      <tbody  class="vertical-table__body">
        @foreach($stats as $stat)
        <tr>
          <td class="txt-centered">
            {{ \App\Consts\StudyProblemConsts::KINDS[$stat->kind] }}
          </td>
          <td>
            {{ $stat->count }}件
          </td>
          <td>
            <div class="progress">
              <div class="progress__bar" style="width:{{ $stat->progress }}%">&nbsp;</div>
              <div class="progress__text">{{ $stat->progress }}%</div>
            </div>
          </td>     
          <td>
            <div class="progress">
              <div class="progress__bar" style="width:{{ $stat->mastery }}%">&nbsp;</div>
              <div class="progress__text">{{ $stat->mastery }}%</div>
            </div>  
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </section>
@endif

<section class="section">
  <h2 class="heading-lv2">検索フォーム</h2>
  <form action="/studies/{{ $study->id }}/problems" method="get">
    種別：<x-forms.drop-box 
      name="kind"
      :options="\App\Consts\StudyProblemConsts::KINDS"
      :hasEmpty="true"
      :selected="$search['kind']"
    />
    Lv：<input type="number" name="difficulty" value="{{ $search['difficulty']}}" class="input-no">
    M：<x-forms.drop-box 
      id="" name="mastery" :options="App\Consts\StudyProblemConsts::MASTERIES"
      :hasEmpty="true"
      :selected="$search['mastery']"
    />以下

    No:
    <input type="number" name="major_min" value="{{ $search['major_min']}}" class="input-no">.
    <input type="number" name="minor_min" value="{{ $search['minor_min']}}" class="input-no">
    ～
    <input type="number" name="major_max" value="{{ $search['major_max']}}" class="input-no">.
    <input type="number" name="minor_max" value="{{ $search['minor_max']}}" class="input-no">

    <input name="random" type="checkbox" @if($search['random']) checked @endif>:ランダム
    <input type="submit" value="検索">
  </form>

  <h2 class="heading-lv2">新規フォーム</h2>
  <form id="create-form">
    <input type="hidden" name="study_id" value="{{ $study->id }}">
    <x-forms.drop-box 
      name="kind"
      :options="\App\Consts\StudyProblemConsts::KINDS"
      :selected="$search['kind']"
    />
    <label for="create-index">Index</label>
    <input type="text" name="index" size="1" value="">
    <input type="text" name="title" size="64" value="">
    <input type="number" name="difficulty" value="1" min="1" max="5" class="input-no">
    <input type="button" value="作成" id="create-button">
  </form>

</section>

<div id="edit-container">
  <h2 class="heading-lv2">編集フォーム</h2>
  <form id="edit-form">
    <input type="hidden" name="id">
    <input type="hidden" name="study_id" value="{{ $study->id }}">
    <x-forms.drop-box 
      name="kind"
      :options="\App\Consts\StudyProblemConsts::KINDS"
    />    
    <input type="text" name="index" size="2"><input type="text" name="title" size="64"><br>
    mastery:<x-forms.drop-box 
      id="" name="mastery" :options="App\Consts\StudyProblemConsts::MASTERIES"
    />
    Lv：<input type="number" name="difficulty" value="1" min="1" max="5" class="input-no">
    <br>
    コメント：<input type="text" name="comment"><br>
    ノートID：<input type="text" name="note_id"><br>
    
    <input type="button" value="更新" id="edit-button">
  </form>
</div>

@if(count($problems) === 0)
  <span>データがありません。</span>
@else
  <h2 class="heading-lv2">目次</h2>
  <table class="vertical-table">
    <thead class="vertical-table__header">
      <tr class="vertical-table__header-row">
        <th style="width:60px;">種別</th>
        <th style="width:60px;">No</th>
        <th>タイトル</th>
        <th style="width:400px">コメント</th>
        <th style="width:50.85px">Lv.</th>
        <th style="width:96px;">Mastery</th>
        <th style="width:60px;">&nbsp;</th>
        <th style="width:42.88px">&nbsp;</th>
        <th style="width:42.88px">&nbsp;</th>
      </tr>
    </thead>
    <tbody  class="vertical-table__body">
      @foreach($problems as $problem)
        <tr>
          <td class="txt-centered">{{ \App\Consts\StudyProblemConsts::KINDS[$problem->kind] }}</td>
          <td>
            
            @if(is_null($problem->minor) && is_null($problem->micro))
              {{$problem->major}}
            @endif
            @if(!is_null($problem->minor) && is_null($problem->micro))
              {{$problem->major}}.{{$problem->minor}}
            @endif          
            @if(!is_null($problem->minor) && !is_null($problem->micro))
              {{$problem->major}}.{{$problem->minor}}.{{$problem->micro}}
            @endif
          </td>
          <td>
            @if(is_null($problem->minor) && is_null($problem->micro))
              <span style="font-size:16px;">{{ $problem->title }}</span>
            @endif
            @if(!is_null($problem->minor) && is_null($problem->micro))
              <span style="font-size:14px;">{{ $problem->title }}</span>
            @endif          
            @if(!is_null($problem->minor) && !is_null($problem->micro))
              <span style="font-size:12px;">{{ $problem->title }}</span>
            @endif        
            
          </td>
          
          <td><span style="font-size:.75em;">{{ $problem->comment }}</span></td>
          <td class="txt-centered">
            <span style="font-size:.75em;">{{ $problem->difficulty }}</span>
          </td>
          <td>
            <div class="progress" style="width:75px">
              <div class="progress__bar" style="width:{{ $problem->mastery * 10 }}%">&nbsp;</div>
              <div class="progress__text">{{ \App\Consts\StudyProblemConsts::MASTERIES[$problem->mastery] }}</div>
            </div>          
          </td>

          <td class="txt-centered">
            @if ($problem->mastery < 10)
              <i 
                data-id="{{ $problem->id }}" data-study_id="{{ $study->id }}" data-mastery="{{ $problem->mastery + 1 }}"
                class="fas fa-plus-circle cur-pointer edit-mastery" style="color:#6BBED5;"></i>
            @endif
            @if (0 < $problem->mastery)
              <i 
                data-id="{{ $problem->id }}" data-study_id="{{ $study->id }}" data-mastery="{{ $problem->mastery - 1 }}"
                class="fas fa-minus-circle cur-pointer edit-mastery" style="color:#E38692;"></i>          
            @endif             
          </td>
          
          <td class="txt-centered">
            @if (!empty($problem->note_id))
              <a 
                class="before-icon before-icon--note"
                href="/notes/{{$problem->note_id}}/show"></a>
            @endif
          </td>
          <td class="txt-centered">
            <a href="#" onclick="return false;">
              <i data-id="{{ $problem->id }}" class="fas fa-edit edit-button"></i>
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif

@endsection