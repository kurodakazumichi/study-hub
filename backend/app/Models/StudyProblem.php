<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
