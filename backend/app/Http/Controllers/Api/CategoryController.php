<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Category::all();
      return response()->json([
        'message' => 'ok',
        'data'    => $categories
      ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      print_r($request->all());
      $category = new Category();
      $category->fill($request->all())->save();
      return response()->json([
        'message' => 'Category created successfully.',
        'data'    => $category
      ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $category = Category::find($id);
      if ($category) {
        return response()->json([
          'message' => 'ok',
          'data'    => $category
        ], 200);
      } else {
        return response()->json([
          'message' => 'Category not found',
        ], 404);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $update = [
        'name'   => $request->name,
        'author' => $request->order,
      ];

      $category = Category::find($id)->fill($update)->save();
      if ($category) {
        return response()->json([
          'message' => 'Category updated successfully'
        ], 200);
      } else {
        return response()->json([
          'message' => 'Category not found'
        ], 404);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $category = Category::find($id)->delete();
      if ($category) {
        return response()->json([
          'message' => 'Category deleted successfully',
        ], 200);
      } else {
        return response()->json([
          'message' => 'Book not found'
        ], 404);
      }
    }
}
