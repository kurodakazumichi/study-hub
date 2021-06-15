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
}
