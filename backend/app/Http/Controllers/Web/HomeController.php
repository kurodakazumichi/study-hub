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

    $power = 0;

    foreach($skills as $skill) {
      $power += $skill->score;
    }

    foreach($achievements as $achievement) {
      $power += $achievement->score;
    }
    
    return view('home.index', [
      'categories'   => Category::list(),
      'varieties'    => Variety::list(),
      'power'        => $power,
      'skills'       => $skills,
      'achievements' => $achievements,
    ]);
  }
}
