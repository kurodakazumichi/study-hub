<?php

namespace App\Consts;

// Study Indexで使う定数
class StudyConsts 
{
  // 評価
  public const EVALS = [
    0  => '未評価',
    1  => 'ゴミ',
    2  => 'いまいち',
    3  => '普通',
    4  => '良書',
    5  => 'バイブル',
  ];

  public const DIFFICULTIES = [
    1 => 'Rookie',
    2 => 'Easy',
    3 => 'Basic',
    4 => 'Maniac',
    5 => 'Chaos'
  ];
}