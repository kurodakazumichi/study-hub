<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Variety;

class Study extends Model
{
  use HasFactory;
  protected $fillable = ['category_id', 'variety_id', 'name', 'order_no'];
  public static $rules = [
    'category_id' => ['required', 'exists:categories,id'],
    'variety_id'  => ['required', 'exists:varieties,id'],
    'name'        => 'required',
    'order_no'    => 'required|integer|min:0'
  ];

  public function category() {
    return $this->hasOne(Category::class);
  }

  public function variety() {
    return $this->hasOne(Variety::class);
  }

  public static function maxOrderNo() {
    $no = Study::max('order_no');
    return (is_null($no))? 0 : $no + 1;
  }

}
