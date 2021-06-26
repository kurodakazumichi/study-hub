<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Study;
use App\Models\StudyIndex;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $note = new Note();

    try{
      $note->fill($request->all())->save();
      return response201('Note', $note);
    } catch(Exception $e) {
      return response500($e->getMessage());
    }
  }

  public function store_for_study_index($id) 
  {
    $index = StudyIndex::findOrFail($id);

    // 既に関連ノートが存在する場合はエラー
    if (!is_null($index->note_id)) {
      return response422(['既に関連ノートが存在します。']);
    }

    $study = Study::findOrFail($index->study_id);

    $note = new Note();
    $note->category_id = $study->category_id;
    $note->variety_id = $study->variety_id;
    $note->title = "{$study->name} {$index->title}";
    $note->body  = "";

    DB::transaction(function() use($note, $index) {
      $note->save();
      $index->note_id = $note->id;
      $index->save();
    });

    return response201("note", $note);
  }

  /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
      $note = Note::findOrFail($id);

      try{
        $note->fill($request->all())->save();
        return response200('Note', $note);
      } catch(Exception $e) {
        return response500($e->getMessage());
      }
    }  

  /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
  public function show($id)
  {
    $note = Note::findOrFail($id);
    return response200($note);
  }

  /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
  public function destroy($id)
  {
      //
  }
}
