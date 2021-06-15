<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyIndecesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $datas = [
      [1, 1, null, "式と証明"],
      [1, 1, 1   , "3次式の展開と因数分解、二項定理"],
      [1, 1, 2   , "整式の割り算、分数式"],
      [1, 1, 3   , "恒等式"],
      [1, 1, 4   , "等式・不等式の証明"],
      [1, 2, null, "複素数と方程式"],
      [1, 2, 1   , "複素数"],
      [1, 2, 2   , "2次方程式の解と判別式"],
      [1, 2, 3   , "解と係数の関係"],
      [1, 2, 4   , "余剰の定理と因数定理"],
      [1, 2, 5   , "高次方程式"],
    ];

    foreach($datas as $data) {
      DB::insert("INSERT INTO study_indeces (study_id, major, minor, micro, title) VALUES (2, ?, ?, ?, ?)", $data);
    }
  }
}
