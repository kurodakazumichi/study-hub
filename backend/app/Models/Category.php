<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
  use HasFactory;
  protected $fillable = ['name'];

  // 関連データを持っている
  public static function hasRelated(int $id) {
    if (Study::hasCategory($id)) return true;
    if (Note::hasCategory($id)) return true;
    if (Achievement::hasCategory($id)) return true;
    return false;
  }

  /**
    * カテゴリを並び替える
    * 
    * @param  Category  $from
    * @param  Category  $from
    * @return void
   */
  public static function sort(Category $from, Category $to) 
  {
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

    try {
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
      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return false;
    }
  }
}
