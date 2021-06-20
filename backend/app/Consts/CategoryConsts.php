<?php

namespace App\Consts;

// Study Indexで使う定数
class CategoryConsts 
{
  // Validation ルール
  public static $rules = [
    'name'     => 'required|max:255',
    'order_no' => 'required|integer|min:0'
  ];
}