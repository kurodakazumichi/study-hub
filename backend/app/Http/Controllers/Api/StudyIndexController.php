<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Study;
use App\Models\StudyIndex;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyIndexController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
      $data = array_merge($request->all(), ['study_id' => $id]);
      $index = new StudyIndex();
      $index->fill($data)->save();
      return response201('index', $index);
    }

    public function update(Request $request, $study_id, $index_id)
    {
      $index = StudyIndex::findOrFail($index_id);
      $index->fill($request->all())->save();
      return response200();
    }

    public function show($study_id, $index_id) {
      $index = StudyIndex::findOrFail($index_id);
      return response200($index);
    }

    /**
     * CSVによる一括登録処理
     */
    public function batch(Request $request, $id) 
    {
      Study::findOrFail($id);

      $text = $request->text;

      // エラーチェック
      if (!$text) {
        return response422(["textは必須です。"]);
      }
      
      // 改行で分割
      $text = str_replace(array("\r\n", "\r", "\n"), '\n', $text);
      $datas = explode('\n', $text);

      // 最低でもヘッダ行とデータ行で2行は必要
      if (count($datas) < 2) {
        return response422(["登録するデータが検出できませんでした。"]);
      }

      // ヘッダ解析
      $headers = explode(',', $datas[0]);

      // ヘッダはmajor, minor, micro, title, masteryの5項目のみ
      if (5 < count($headers)) {
        return response422("headerの項目が多すぎます。");
      }

      foreach($headers as $index => $value) {
        $value = trim($value);

        if (!in_array($value, ['major', 'minor', 'micro', 'title', 'mastery'])){
          return response422(["headerに無効な項目が含まれています"]);
        }

        $headers[$index] = $value;
      }

      $params = [];
      for($i = 1; $i < count($datas); ++$i) {

        $params[$i] = ['study_id' => $id];

        foreach($headers as $index => $key) {
          $tmp = explode(',', $datas[$i]);

          if (count($tmp) !== 5) {
            return response422([$i . "行目が無効です。"]);
          }

          switch($key) {
            case "minor":
            case "micro":
              $params[$i][$key] = ($tmp[$index] === "")? null : $tmp[$index]; break;
            case "mastery":
              $params[$i][$key] = ($tmp[$index] === "")? 0 : $tmp[$index]; break;
            default:
              $params[$i][$key] = $tmp[$index];  break;
          }
        }
      }

      $delete_query = "DELETE FROM study_indices where study_id = ?";

      DB::beginTransaction();

      try{
        DB::delete($delete_query, [$id]);
        DB::table('study_indices')->insert($params);
        DB::commit();
        return response200();
      } catch (Exception $e) {
        DB::rollBack();
        return response500($e->getMessage());
      }
    }
}
