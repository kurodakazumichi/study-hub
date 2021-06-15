<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variety;

class VarietyController extends Controller
{
  public function index() {
    $varieties = Variety::all()->sortBy('order_no');
    return view('variety.index', ['varieties' => $varieties]);    
  }
}
