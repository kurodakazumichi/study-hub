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
      'random' => "",
      'no_min' => "",
      'no_max' => "",
    ];

    if (!is_null($request->kind)) {
      $search['kind'] = $request->kind;
    }
    if (!is_null($request->mastery)) {
      $search['mastery'] = $request->mastery;
    }
    if (!is_null($request->random)) {
      $search["random"] = "on";
    }
    if (!is_null($request->no_min)) {
      $search["no_min"] = $request->no_min;
    }
    if (!is_null($request->no_max)) {
      $search["no_max"] = $request->no_max;
    }

    $study = Study::findOrFail($id);
    $problems = StudyProblem::where('study_id', $id);

    if (!is_null($search['kind']) && $search['kind'] !== "") {
      $problems = $problems->where('kind', $search['kind']);
    }

    if (!is_null($search['mastery']) && $search['mastery'] !== "") {
      $problems = $problems->where('mastery', '<=', $search['mastery']);
    }

    if($search['no_min'] !== "") {
      $problems = $problems->where('major', '>=', $search['no_min']);
    }

    if($search['no_max'] !== "") {
      $problems = $problems->where('major', '<=', $search['no_max']);
    }    

    $problems = $problems
      ->orderBy('kind')
      ->orderBy('major')
      ->orderBy('minor')
      ->orderBy('micro')
      ->get();

    $stats = StudyProblem::stats($id);

    // ランダム指定の場合は、ランダムに1問だけ表示
    if ($problems->count() !== 0 && !empty($search['random'])) {
      $tmp = $problems->all();
      shuffle($tmp);
      $problems = [$tmp[0]];
    }

    return view('study_problem.index', [
      'study'    => $study,
      'problems' => $problems,
      'stats'    => $stats,
      'search'   => $search
    ]);
  }
}
