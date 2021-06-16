<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\Category;
use App\Models\Variety;
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
      $where['category_id'] = $request->category_id;
    }

    if (!empty($search['variety_id'])) {
      $where['variety_id'] = $request->variety_id;
    }

    //-------------------------------------------------------------------------
    // Studyデータを取得
    $studies = Study::with(['category', 'variety'])
      ->where($where)
      ->orderBy('order_no')
      ->get();
    
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
