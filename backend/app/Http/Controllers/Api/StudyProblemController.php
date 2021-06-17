<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudyProblem;
use Illuminate\Http\Request;

class StudyProblemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $study_id)
    {
      $data = array_merge($request->all(), ['study_id' => $study_id]);
      $problem = new StudyProblem();
      $problem->fill($data)->save();
      return response201('problem', $problem);
    }
 
    public function update(Request $request, $study_id, $problem_id)
    {
       $problem = StudyProblem::findOrFail($problem_id);
       $problem->fill($request->all())->save();
       return response200();
    }

    public function show($study_id, $problem_id) {
      $problem = StudyProblem::findOrFail($problem_id);
      return response200($problem);
    }     
}
