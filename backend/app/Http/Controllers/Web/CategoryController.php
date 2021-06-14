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

  function create() {
    return view('category.create');
  }

  function store(Request $req) 
  {
    $this->validate($req, Category::$rules);
    $category = new Category();
    $category->fill($req->except('_token'))->save();
    return redirect('categories/create');
  }

  function edit($id) {
    return view('category.edit', ['category' => Category::findOrFail($id)]);
  }

  function update(Request $req, $id)
  {
    $category = Category::find($id);

    $category->fill($req->except('_token', '_method'))->save();
    return redirect('/categories');
  }

}
