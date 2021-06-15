<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\Category;
use App\Models\Variety;
class StudyController extends Controller
{
  public function index() {

    $data = [
      'categories' => Category::orderBy('order_no')->get(['id', 'name']),
      'varieties'  => Variety::orderBy('order_no')->get(['id', 'name']),
    ];

    return view('study.index', $data);
  }
}
