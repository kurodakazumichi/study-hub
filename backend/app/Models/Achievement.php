<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

  public static function hasCategory($id) {
    return Achievement::where('category_id', $id)->exists();
  }

  public static function getStats() 
  {
    $stats = Achievement::select(
      'category_id',
      DB::raw('count(id) as count'),
      DB::raw('sum(CASE WHEN achievement_at is null THEN 0 ELSE 1 END) as cleared'),
      DB::raw('sum(CASE WHEN achievement_at is null THEN 0 ELSE difficulty END) as score')      
    )
    ->groupBy('category_id')
    ->orderBy('category_id')
    ->get();

    foreach($stats as $stat) {
      $stat->progress = round($stat->cleard / $stat->count, 3) * 100;
    }
    
    return $stats;
  }
}
