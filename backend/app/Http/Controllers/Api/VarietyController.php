<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variety;

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
}
