<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Study;

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
    $studies = Study::with(['category', 'variety'])->orderBy('order_no')->get();
    foreach($studies as $study) {
      echo $study->category->id;
      echo $study->category->name;
    }
    dd(DB::getQueryLog());
  }

  public function debug01() {

    /*
    | id | order |
    | 1  | 0     |
    | 2  | 1     |
    | 3  | 2     |

    1→3にもっていく場合
    ①id=1のorderを2にする
    | id | order |
    | 1  | 2     |
    | 2  | 1     |
    | 3  | 2     |    

    ②0 <= order <= 2 and id != 1のorderを-1する 
    | id | order |
    | 1  | 2     |
    | 2  | 0     |
    | 3  | 1     | 

    UPDATE categories as c
    SET c.order = 2

    UPDATE categories as c SET c.order = 0;

    UPDATE categories as c SET c.order = 1 where id = 2;
    UPDATE categories as c SET c.order = 2 where id = 5;
    */
    
    // request
    $from_id = 2;
    $to_id   = 1;

    // fromに該当するorderを取得
    $from_order = Category::find($from_id)->order_no;
    $to_order = Category::find($to_id)->order_no;

    // 後ろのレコードを前に持ってくる場合は逆転させて処理を統一する
    if ($to_order < $from_order) {
      $tmp = $from_id;
      $from_id = $to_id;
      $to_id = $tmp;
      $tmp = $from_order;
      $from_order = $to_order;
      $to_order = $tmp;
    }

    $sql1 = 'UPDATE categories as c SET c.order_no = :to_order where c.id = :from_id';

    $sql2 = <<< SQL
      UPDATE categories as c 
      SET c.order_no = c.order_no - 1
      WHERE c.id != ?
      AND c.order_no >= ?
      AND c.order_no <= ?
    SQL;

    DB::enableQueryLog();
    DB::update($sql1, ['to_order' => $to_order, 'from_id' => $from_id]);
    DB::update($sql2, [$from_id, $from_order, $to_order]);
    dd(DB::getQueryLog());

    return;
  }
}
