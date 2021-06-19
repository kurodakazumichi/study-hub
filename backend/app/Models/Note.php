<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  use HasFactory;
  protected $fillable = ['category_id', 'variety_id', 'title', 'body'];
  public static $rules = [
    'category_id' => ['required', 'exists:categories,id'],
    'variety_id'  => ['required', 'exists:varieties,id'],
    'title'       => ['required', 'max:255'],
    'body'        => ['required']
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function variety() {
    return $this->belongsTo(Variety::class);
  }

  public static function hasCategory($id) {
    return Note::where('category_id', $id)->exists();
  }    
}
