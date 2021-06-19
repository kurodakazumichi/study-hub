<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
  use HasFactory;
  protected $fillable = ['category_id', 'variety_id', 'title', 'condition', 'difficulty', 'note_id', 'achievement_at'];
  public static $rules = [
    'category_id'    => ['required', 'exists:categories,id'],
    'variety_id'     => ['required', 'exists:varieties,id'],
    'title'          => ['required', 'max:255'],
    'condition'      => ['required', 'max:255'],
    'difficulty'     => ['required', 'integer', 'min:1', 'max:5'],
    'note_id'        => ['exists:notes,id'],
    'achievement_at' => ['date']
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function variety() {
    return $this->belongsTo(Variety::class);
  }

  public function note() {
    return $this->belongsTo(Note::class);
  }  
}
