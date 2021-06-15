<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Study;
use App\Models\StudyIndex;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class StudyIndexController extends Controller
{
  public function index(Request $request, $id) 
  {
    $study = Study::findOrFail($id);
    $indices = StudyIndex::where('study_id', $id)
      ->orderBy('major')
      ->orderBy('minor')
      ->orderBy('micro')
      ->get();


    return view('study_index.index', [
      'study'   => $study,
      'indices' => $indices
    ]);
  }
}
