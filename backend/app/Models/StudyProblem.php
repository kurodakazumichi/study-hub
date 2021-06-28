<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudyProblem extends Model
{
  use HasFactory;
  protected $fillable = ['study_id', 'kind', 'mastery', 'major', 'minor', 'micro', 'title', 'comment', 'note_id'];
  
  public static $rules = [
    'study_id' => ['required', 'exists:studies,id'],
    'kind'     => ['required', 'integer', 'min:0', 'max:5'],
    'mastery'  => ['integer', 'min:0', 'max:10'],
    'major'    => ['required', 'integer', 'min:0', 'max:10'],
    'minor'    => ['integer', 'min:0', 'max:10'],
    'micro'    => ['integer', 'min:0', 'max:10'],
    'title'    => ['required', 'max:255'],
    'comment'  => ['max:255'],
    'note_id'  => ['exists:notes,id'],
  ];

  public function study() {
    return $this->belongsTo(Study::class);
  }

  public static function stats($study_id) 
  {
    $stats = DB::table('study_problems as t')
      ->select(
        't.kind',
        DB::raw('count(t.id) as count'),
        DB::raw('sum(CASE WHEN t.mastery != 0 THEN 1 ELSE 0 END) as done_count'),
        DB::raw('(sum(mastery) / (count(id) * 10)) as mastery')
      )
      ->where(['t.study_id' => $study_id])
      ->groupBy('t.kind')
      ->orderBy('t.kind')
      ->get();

      foreach($stats as $key => $stat) {

        $count   = $stat->count;
        $done    = $stat->done_count;
        $mastery = $stat->mastery; 
  
        if ($count === 0) {
          $stat->progress = 0;
          $stat->mastery = 0;
          continue;
        }
  
        // 進捗率
        $stat->progress = round($done / $count, 3) * 100;
  
        // 習得率
        $stat->mastery = round($mastery, 3) * 100;
      }

    return $stats;
  }
}
