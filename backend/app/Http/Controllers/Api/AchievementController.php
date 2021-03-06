<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;
use Exception;

class AchievementController extends Controller
{
  /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
  public function store(Request $request)
  {
    $achievement = new Achievement();
  
    try{
      $achievement->fill($request->all())->save();
      return response201('Achievement', $achievement);
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
    $achievement = Achievement::findOrFail($id);
    return response200($achievement);
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
    $achievement = Achievement::findOrFail($id);
  
    try{
      $achievement->fill($request->all())->save();
      return response200();
    } catch(Exception $e) {
      return response500($e->getMessage());
    }
  }

  public function open($id) 
  {
    $achievement = Achievement::findOrFail($id);

    if (!is_null($achievement->achievement_at)) {
      return response200();
    }

    $achievement->achievement_at = date('Y-m-d H:i:s');
    $achievement->save();
    return response200();
  }

  public function close($id) 
  {
    $achievement = Achievement::findOrFail($id);

    if (is_null($achievement->achievement_at)) {
      return response200();
    }

    $achievement->achievement_at = null;
    $achievement->save();
    return response200();

  }

  /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
  public function destroy($id)
  {

  }
}
