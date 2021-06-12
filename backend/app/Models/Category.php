<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'order'];
  public static $rules = [
    'name' => 'required',
    'order' => 'required|integer|min:0'
  ];
}
