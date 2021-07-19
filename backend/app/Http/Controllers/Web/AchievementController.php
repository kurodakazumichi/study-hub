<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Variety;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
  public function index(Request $request) 
  {
    $search = [
      'category_id' => '',
      'variety_id' => '',
    ];

    if (!is_null($request->category_id)){
      $search['category_id'] = $request->category_id;
    }
    
    if (!is_null($request->variety_id)){
      $search['variety_id'] = $request->variety_id;
    }

    $where = [];

    if (!empty($search['category_id'])) {
      $where['a.category_id'] = $search['category_id'];
    }

    if (!empty($search['variety_id'])) {
      $where['a.variety_id'] = $search['variety_id'];
    }

    $achievements = DB::table("achievements as a")
      ->leftJoin('categories as c', 'a.category_id', '=', 'c.id')
      ->leftJoin('varieties as v' , 'a.variety_id' , '=', 'v.id')
      ->where($where)
      ->orderBy('c.order_no')
      ->orderBy('a.difficulty', 'desc')
      ->get();

    return view('achievement.index', [
      'search'       => $search,
      'achievements' => $achievements,
      'categories'  => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'   => Variety::orderBy('order_no')->pluck('name', 'id'),
    ]);
  }
}
