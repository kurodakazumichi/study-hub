<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Study;
use App\Models\StudyIndex;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyIndexController extends Controller
{
  public function index(Request $request, $id) 
  {
    $search = [
      'mastery'=> "",
      'random' => "",
      'major_min' => "",
      'minor_min' => "",
      'major_max' => "",
      'minor_max' => "",
    ];

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
    $indices = StudyIndex::where('study_id', $id);

    if (!is_null($search['mastery']) && $search['mastery'] !== "") {
      $indices = $indices->where('mastery', '=', $search['mastery']);
    }

    if($search['major_min'] !== "") {
      $indices = $indices->where('major', '>=', $search['major_min']);
    }

    if($search['major_max'] !== "") {
      $indices = $indices->where('major', '<=', $search['major_max']);
    }    

    if($search['minor_min'] !== "") {
      $indices = $indices->where('minor', '>=', $search['minor_min']);
    }

    if($search['minor_max'] !== "") {
      $indices = $indices->where('minor', '<=', $search['minor_max']);
    }    

    $indices = $indices
      ->orderBy('major')
      ->orderBy('minor')
      ->orderBy('micro')
      ->get();

    $stats = StudyIndex::getStatsBy($id);

    return view('study_index.index', [
      'search'  => $search,
      'study'   => $study,
      'stats'   => $stats,
      'indices' => $indices,
    ]);
  }
}
