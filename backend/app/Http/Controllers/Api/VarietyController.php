<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variety;
use Illuminate\Support\Facades\DB;

class VarietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
      $order_no = Variety::maxOrderNo();

      // ヴァラエティの新規作成
      $variety = new Variety();
      $variety->fill([
        'name'     => $request->get('name'),
        'order_no' => $order_no,
      ])->save();

      // レスポンス
      return response201('Variety', $variety);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      ];

      $variety = Variety::find($id)->fill($update)->save();
      
      if ($variety) {
        return response200();
      } else {
        return response404('Variety');
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
        //
    }

    /**
     * カテゴリの並び順を更新。
     */
    public function order(Request $request, $id) {

      $from = Variety::find($id);

      // カテゴリがなかったら終了
      if(is_null($from)) {
        return response404('The specified variery');
      }

      $to = Variety::where('order_no', $request->order_no)->first();

      // 移動先のカテゴリがなかったら終了
      if (is_null($to)) {
        return response404('Destination variery');
      }

      // カテゴリを移動するSQL
      $sql1 = <<< SQL
        UPDATE varieties as v
        SET v.order_no = :to_order_no
        WHERE v.id = :from_id
      SQL;

      // 全体的にずらすSQL
      $sql2 = <<< SQL
        UPDATE varieties as v SET 
          v.order_no = v.order_no + (:value)
        WHERE 
          v.id != :ignore_id
          AND v.order_no >= :min_order_no
          AND v.order_no <= :max_order_no
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
        return response200();

      } catch(\Exception $e) {
        DB::rollBack();
        response500($e->getMessage());
      }
    }    
}
