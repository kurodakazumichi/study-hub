<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
