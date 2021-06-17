<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\StudyProblem;

class StudyProblemController extends Controller
{
  public function index(Request $request, $id) 
  {
    $study = Study::findOrFail($id);
    $problems = StudyProblem::where('study_id', $id)
      ->orderBy('kind')
      ->orderBy('major')
      ->orderBy('minor')
      ->orderBy('micro')
      ->get();

    return view('study_problem.index', [
      'study'   => $study,
      'problems' => $problems,
    ]);
  }
}
