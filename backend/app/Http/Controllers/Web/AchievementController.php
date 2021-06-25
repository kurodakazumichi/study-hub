<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Variety;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
  public function index(Request $request) 
  {
    $search = [
      'category_id' => '',
      'variety_id' => '',
    ];

    $achievements = Achievement::all();

    return view('achievement.index', [
      'search'       => $search,
      'achievements' => $achievements,
      'categories'  => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'   => Variety::orderBy('order_no')->pluck('name', 'id'),
    ]);
  }
}
