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
    $search = [
      'kind'   => "",
      'mastery'=> "",
    ];

    if (!is_null($request->kind)) {
      $search['kind'] = $request->kind;
    }
    if (!is_null($request->mastery)) {
      $search['mastery'] = $request->mastery;
    }

    $study = Study::findOrFail($id);
    $problems = StudyProblem::where('study_id', $id);

    if (!is_null($search['kind']) && $search['kind'] !== "") {
      $problems = $problems->where('kind', $search['kind']);
    }

    if (!is_null($search['mastery'] && $search['mastery'] !== "")) {
      $problems = $problems->where('mastery', '<=', $search['mastery']);
    }

    $problems = $problems
      ->orderBy('kind')
      ->orderBy('major')
      ->orderBy('minor')
      ->orderBy('micro')
      ->get();

    return view('study_problem.index', [
      'study'    => $study,
      'problems' => $problems,
      'search'   => $search
    ]);
  }
}
