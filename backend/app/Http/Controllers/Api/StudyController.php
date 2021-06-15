<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Study;
use Exception;
use App\Http\Requests\StudyStoreRequest;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudyStoreRequest $request)
    {
      $study = new Study();
      $data = array_merge($request->all(), ['order_no' => Study::maxOrderNo()]);

      try{
        $study->fill($data)->save();
        return response201('Study', $study);
      } catch(Exception $e) {
        return response500($e->getMessage());
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
      //
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
     * Studyの並び順を更新。
     */
    public function sort(Request $request, $id) {

      $from = Study::find($id);

      // 該当するstudyがなかったら終了
      if(is_null($from)) {
        return response404('The specified study');
      }

      $to = Study::find($request->to_id);

      // 該当するstudyがなかったら終了
      if (is_null($to)) {
        return response404('Destination variery');
      }

      // カテゴリを移動するSQL
      $sql1 = <<< SQL
        UPDATE studies as t
        SET t.order_no = :to_order_no
        WHERE t.id = :from_id
      SQL;

      // 全体的にずらすSQL
      $sql2 = <<< SQL
        UPDATE studies as t SET 
          t.order_no = t.order_no + (:value)
        WHERE 
          t.id != :ignore_id
          AND t.order_no >= :min_order_no
          AND t.order_no <= :max_order_no
      SQL;

      DB::beginTransaction();

      try 
      {
        DB::update($sql1, [
          'to_order_no' => $to->order_no,
          'from_id'     => $from->id
        ]);
  
        DB::update($sql2, [
          'value'        => ($from->order_no < $to->order_no)? -1 : +1,
          'ignore_id'    => $from->id,
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
