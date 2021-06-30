<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudyIndex extends Model
{
  use HasFactory;
  protected $fillable = ['study_id', 'mastery', 'major', 'minor', 'micro', 'title', 'comment', 'note_id', 'link'];
  
  public static $rules = [
    'study_id' => ['required', 'exists:studies,id'],
    'mastery'  => ['integer', 'min:0', 'max:10'],
    'major'    => ['required', 'integer', 'min:0', 'max:10'],
    'minor'    => ['integer', 'min:0', 'max:10'],
    'micro'    => ['integer', 'min:0', 'max:10'],
    'title'    => ['required', 'max:255'],
    'comment'  => ['max:255'],
    'note_id'  => ['exists:notes,id'],
    'link'     => ['max:255'],
  ];

  public function study() {
    return $this->belongsTo(Study::class);
  }

  public static function getStatsBy($study_id) 
  {  
    $stats = StudyIndex::select(
      'study_id',
      DB::raw('count(id) as count'),
      DB::raw('sum(CASE WHEN mastery != 0 THEN 1 ELSE 0 END) as done_count'),
      DB::raw('sum(mastery) as mastery')
    )
    ->where('study_id', $study_id)
    ->groupBy('study_id')
    ->get();

    foreach($stats as $stat) {
      $stat->progress = round($stat->done_count / $stat->count, 3) * 100;
      $stat->mastery  = round($stat->mastery / ($stat->count * 10), 3) * 100;
    }

    return $stats[0];
  }
}
