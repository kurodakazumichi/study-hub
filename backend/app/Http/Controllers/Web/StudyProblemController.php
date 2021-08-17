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
      'major_min' => "",
      'minor_min' => "",
      'major_max' => "",
      'minor_max' => "",
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
    if (!is_null($request->major_min)) {
      $search["major_min"] = $request->major_min;
    }
    if (!is_null($request->minor_min)) {
      $search["minor_min"] = $request->minor_min;
    }
    if (!is_null($request->major_max)) {
      $search["major_max"] = $request->major_max;
    }
    if (!is_null($request->minor_max)) {
      $search["minor_max"] = $request->minor_max;
    }

    $study = Study::findOrFail($id);
    $problems = StudyProblem::where('study_id', $id);

    if (!is_null($search['kind']) && $search['kind'] !== "") {
      $problems = $problems->where('kind', $search['kind']);
    }

    if (!is_null($search['mastery']) && $search['mastery'] !== "") {
      $problems = $problems->where('mastery', '<=', $search['mastery']);
    }

    print_r($search);
    if($search['major_min'] !== "") {
      $problems = $problems->where('major', '>=', $search['major_min']);
    }

    if($search['major_max'] !== "") {
      $problems = $problems->where('major', '<=', $search['major_max']);
    }    

    if($search['minor_min'] !== "") {
      $problems = $problems->where('minor', '>=', $search['minor_min']);
    }

    if($search['minor_max'] !== "") {
      $problems = $problems->where('minor', '<=', $search['minor_max']);
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
