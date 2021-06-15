<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

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
      // 表示順の最大値を取得する
      $order_no = Category::max('order_no');
      $order_no = is_null($order_no)? 0 : $order_no + 1;

      // カテゴリの新規作成
      $category = new Category();
      $category->fill([
        'name'     => $request->get('name'),
        'order_no' =>  $order_no,
      ])->save();

      // レスポンス
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

    /**
     * カテゴリの並び順を更新。
     */
    public function order(Request $request, $id) {

      $from = Category::find($id);

      // カテゴリがなかったら終了
      if(is_null($from)) {
        return response404('The specified category');
      }

      $to = Category::where('order_no', $request->order_no)->first();

      // 移動先のカテゴリがなかったら終了
      if (is_null($to)) {
        return response404('Destination category');
      }

      // カテゴリを移動するSQL
      $sql1 = <<< SQL
        UPDATE categories as c
        SET c.order_no = :to_order_no
        WHERE c.id = :from_id
      SQL;

      // 全体的にずらすSQL
      $sql2 = <<< SQL
        UPDATE categories as c SET 
          c.order_no = c.order_no + (:value)
        WHERE 
          c.id != :ignore_id
          AND c.order_no >= :min_order_no
          AND c.order_no <= :max_order_no
      SQL;

      DB::beginTransaction();

      try 
      {
        DB::update($sql1, [
          'to_order_no' => $to->order_no,
          'from_id'     => $id
        ]);
  
        DB::update($sql2, [
          'value'        => ($from->order_no < $to->order_no)? -1 : +1,
          'ignore_id'    => $id,
          'min_order_no' => min($from->order_no, $to->order_no),
          'max_order_no' => max($from->order_no, $to->order_no)
        ]);

        DB::commit();

        return response()->json([
          'message' => 'category sorted successfully.'
        ], 200);

      } catch(\Exception $e) {
        DB::rollBack();
        response500($e->getMessage());
      }
    }
}
