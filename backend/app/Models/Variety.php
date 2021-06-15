<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'order_no'];
  public static $rules = [
    'name' => 'required',
    'order_no' => 'required|integer|min:0'
  ];
  
  public static function maxOrderNo() {
    $no = Variety::max('order_no');
    return (is_null($no))? 0 : $no + 1;
  }
}
