<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyIndex extends Model
{
  use HasFactory;
  protected $fillable = ['study_id', 'mastery', 'major', 'minor', 'micro', 'title', 'comment', 'link'];
  
  public static $rules = [
    'study_id' => ['required', 'exists:studies,id'],
    'mastery'  => ['integer', 'min:0', 'max:10'],
    'major'    => ['required', 'integer', 'min:0', 'max:10'],
    'minor'    => ['integer', 'min:0', 'max:10'],
    'micro'    => ['integer', 'min:0', 'max:10'],
    'title'    => ['required', 'max:255'],
    'comment'  => ['max:255'],
    'link'     => ['max:255'],
  ];

  public function study() {
    return $this->belongsTo(Study::class);
  }
}
