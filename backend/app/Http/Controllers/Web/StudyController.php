<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\Category;
use App\Models\Variety;
use Illuminate\Support\Facades\DB;
class StudyController extends Controller
{
  /**
   * Study一覧
   */
  public function index(Request $request) 
  {
    //-------------------------------------------------------------------------
    // 検索フォームの値
    $search = [
      'category_id' => $request->category_id,
      'variety_id'  => $request->variety_id,
    ];

    //-------------------------------------------------------------------------
    // 検索条件データを準備
    $where = [];

    if(!empty($search['category_id'])) {
      $where['s.category_id'] = $request->category_id;
    }

    if (!empty($search['variety_id'])) {
      $where['s.variety_id'] = $request->variety_id;
    }

    //-------------------------------------------------------------------------
    // Studyデータを取得
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
      ->where($where)
      ->groupBy('i.study_id')
      ->orderBy('s.category_id')
      ->orderBy('s.variety_id')
      ->orderBy('s.order_no')
      ->get();
    
    foreach($studies as $key => $study) {

      $count    = $study->index_count;
      $finished = $study->finished_count;
      $mastery  = $study->mastery; 

      // 進捗率
      $study->progress = round($finished / $count, 3) * 100;

      // 習得率
      $study->mastery = round($mastery / ($count * 10), 3) * 100;
    }

    //-------------------------------------------------------------------------
    // View設定  
    $data = [
      'search'     => $search,
      'studies'   => $studies,
      'categories' => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'  => Variety::orderBy('order_no')->pluck('name', 'id'),
    ];

    return view('study.index', $data);
  }

  public function edit(Request $request, $id) 
  {
    //-------------------------------------------------------------------------
    // Studyデータを取得
    $study = Study::with(['category', 'variety'])
      ->findOrFail($id);

    return view('study.edit', [
      'study'      => $study,
      'categories' => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'  => Variety::orderBy('order_no')->pluck('name', 'id'),  
    ]);
  }
}
