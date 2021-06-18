<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
  use HasFactory;
  protected $fillable = ['category_id', 'variety_id', 'name', 'order_no', 'link'];
  public static $rules = [
    'category_id' => ['required', 'exists:categories,id'],
    'variety_id'  => ['required', 'exists:varieties,id'],
    'name'        => 'required',
    'order_no'    => 'required|integer|min:0',
    'link'        => 'max:255',
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function variety() {
    return $this->belongsTo(Variety::class);
  }

  public static function maxOrderNo() {
    $no = Study::max('order_no');
    return (is_null($no))? 0 : $no + 1;
  }

}
