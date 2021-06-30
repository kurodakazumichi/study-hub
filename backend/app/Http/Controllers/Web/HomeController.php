<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Category;
use App\Models\Study;
use App\Models\Variety;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index() {

    $skills        = Study::getStats();
    $achievements = Achievement::getStats();
    
    return view('home.index', [
      'categories'   => Category::list(),
      'varieties'    => Variety::list(),
      'skills'        => $skills,
      'achievements' => $achievements,
    ]);
  }
}
