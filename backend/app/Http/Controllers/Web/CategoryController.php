<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
  function index() {
    $categories = Category::all()->sortBy('order_no');
    return view('category.index', ['categories' => $categories]);
  }
}