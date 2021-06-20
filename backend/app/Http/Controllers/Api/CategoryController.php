<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Category\CategoryStore;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
  public function store(CategoryStore $request)
  {
    // 表示順の最大値を取得する
    $order_no = Category::max('order_no');
    $order_no = is_null($order_no)? 0 : $order_no + 1;

    // カテゴリの新規作成
    $category = new Category();
    $category->name     = $request->name;
    $category->order_no = $order_no;

    $category->save();

    // レスポンス
    return response()->json([
      'message' => 'Category created successfully.',
      'data'    => $category
    ], 201);
  }

  public function update(CategoryStore $request, $id)
  {
    $category = Category::find($id);

    if (is_null($category)) {
      return response404('Category');
    }

    $category->fill($request->all())->save();
    
    return response()->json([
      'message' => 'Category updated successfully'
    ], 200);
  }

  public function destroy($id)
  {
    // idに該当するカテゴリを取得
    $category = Category::find($id);
    
    // 見つからなければ404
    if (is_null($category)) return response404('Category');

    // 関連データがある場合は削除できない。
    if (Category::hasRelated($id)) {
      return response422(["「{$category->name}」は他で使われているため削除できません。"]);
    }

    // 削除
    $category->delete();
    return response200();
  }

  /**
   * カテゴリの並び順を更新。
   */
  public function sort(Request $request) {

    $from = Category::find($request->from_id);

    // カテゴリがなかったら終了
    if(is_null($from)) {
      return response404('The specified category');
    }

    $to = Category::find($request->to_id);

    // 移動先のカテゴリがなかったら終了
    if (is_null($to)) {
      return response404('Destination category');
    }

    try 
    {
      Category::sort($from, $to);

      return response()->json([
        'message' => 'category sorted successfully.'
      ], 200);

    } catch(\Exception $e) {
      DB::rollBack();
      response500($e->getMessage());
    }
  }  
}
