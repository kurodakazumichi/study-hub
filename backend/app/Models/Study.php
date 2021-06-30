<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Study extends Model
{
  use HasFactory;
  protected $fillable = ['category_id', 'variety_id', 'name', 'order_no', 'link', 'note_id', 'eval', 'comment'];
  public static $rules = [
    'category_id' => ['required', 'exists:categories,id'],
    'variety_id'  => ['required', 'exists:varieties,id'],
    'name'        => 'required',
    'order_no'    => 'required|integer|min:0',
    'link'        => 'max:255',
    'note_id'     => ['exists:notes,id'],
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

  public static function maxOrderNo() {
    $no = Study::max('order_no');
    return (is_null($no))? 0 : $no + 1;
  }

  public static function hasCategory($id) {
    return Study::where('category_id', $id)->exists();
  }

  public static function getStats() {
    $sql = <<< SQL
      SELECT
        s.category_id,
        sum(i.score) as i_score,
        sum(p.score) as p_score
      FROM
        studies as s
      LEFT JOIN
        (
        SELECT
          study_id,
          sum(mastery) as score
        FROM 
          study_indices
        GROUP BY
          study_id
        ) as i
        ON i.study_id = s.id
      LEFT JOIN
        (
        SELECT
          study_id,
          sum(mastery) as score
        FROM
          study_problems
        GROUP BY
          study_id
        ) as p
        ON p.study_id = s.id
      GROUP BY
        s.category_id
      ORDER BY
        s.category_id
    SQL;

    $stats = DB::select($sql);

    $max = 0;

    foreach($stats as $stat) {
      $i_score = is_null($stat->i_score)? 0 : $stat->i_score;
      $p_score = is_null($stat->p_score)? 0 : $stat->p_score;
      $stat->score = $i_score + $p_score;

      $max = max($max, $stat->score);
    }

    foreach($stats as $stat) {
      $stat->rate = round($stat->score / ($max + 100), 3) * 100;
    }

    return $stats;
  }

}
