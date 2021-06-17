<?php

namespace App\Consts;

// Study Indexで使う定数
class StudyProblemConsts 
{
  // 習得度(mastery)リストの定数
  public const MASTERIES = [
    0  => '未回答',
    1  => 'Lv1',
    2  => 'Lv2',
    3  => 'Lv3',
    4  => 'Lv4',
    5  => 'Lv5',
    6  => 'Lv6',
    7  => 'Lv7',
    8  => 'Lv8',
    9  => 'Lv9',
    10 => 'Master',
  ];

  public const KINDS = [
    0 => '例題',
    1 => 'EX',
    2 => 'EXERCISES',
    3 => '演習',
    4 => '章末問題',
  ];
}