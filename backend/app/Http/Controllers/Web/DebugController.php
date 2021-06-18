<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Study;
use App\Models\StudyIndex;

class DebugController extends Controller
{
  public function index() {
    return view("debug.index");
  }

  /**
   * Laravelの英語の複数形を確認できるページ、複数形を確認したい単語をqueryパラメータで指定する
   * ex. /debug/plural?word=car
   */
  public function plural(Request $request) {
    return Str::plural($request->get('word'));
  }

  public function query() 
  {
    DB::enableQueryLog();

    //$this->query01();
    //$this->query02();
    $this->query03();
    dd(DB::getQueryLog());
  }

  private function query01() {
    // テーブルの結合
    $studies = Study::with(['category', 'variety'])->orderBy('order_no')->get();
    foreach($studies as $study) {
      echo $study->category->id;
      echo $study->category->name;
    }
  }
  private function query02() {
    // 生クエリ
    $sql = <<< SQL
      SELECT
        s.id,
        s.name,
        s.category_id,
        s.variety_id,
        count(i.id) as index_count,
        sum(CASE WHEN i.mastery != 0 THEN 1 ELSE 0 END) as finished_count,
        sum(i.mastery) as mastery
      FROM       
        studies as s
        INNER JOIN study_indices as i
          ON s.id = i.study_id
      WHERE
        1 = 1
        AND s.category_id = 1
      GROUP BY i.study_id
      ORDER BY 
        s.category_id asc, 
        s.variety_id asc,
        s.order_no asc
    SQL;

    echo DB::escape(";a");
    $studies = DB::select($sql);
    print_r($studies);
  }
  private function query03() {
    $studies = DB::table('studies as s')
      ->join('study_indices as i', 's.id', '=', 'i.study_id')
      ->select(
        's.id',
        's.name',
        's.category_id',
        's.variety_id',
        DB::raw('count(i.id) as index_count'),
        DB::raw('sum(CASE WHEN i.mastery != 0 THEN 1 ELSE 0 END) as finished_count'),
        DB::raw('sum(i.mastery) as mastery')
      )
      ->groupBy('i.study_id')
      ->orderBy('s.category_id')
      ->orderBy('s.variety_id')
      ->orderBy('s.order_no')
      ->get();
    print_r($studies);
  }

  public function diary() {
    $study_ids = StudyIndex::where('updated_at', '>=', date('Y-m-d 00:00:00'))
      ->where('mastery', '>=', 1)
      ->groupBy('study_id')->pluck('study_id');

    $indices = StudyIndex::where('updated_at', '>=', date('Y-m-d 00:00:00'))
      ->orderBy('study_id')
      ->orderBy('updated_at')
      ->get();

    $studies = Study::whereIn('id', $study_ids)->get(['id', 'name']);



    foreach($studies as $study) {
      $study->indices = StudyIndex::where('study_id', '=', $study->id)
        ->where('updated_at', '>=', date('Y-m-d 00:00:00'))
        ->where('mastery', '>=', 1)
        ->orderBy('updated_at')
        ->get(['title']);
    }

    return view("debug.diary", [
      'studies' => $studies,
    ]);
  }
}


