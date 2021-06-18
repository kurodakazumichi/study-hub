<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

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
