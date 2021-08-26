<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDifficultyToStudyProblems extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('study_problems', function (Blueprint $table) 
    {
      $table->after('micro', function($table) {
        $table->tinyInteger('difficulty')->default(1);
      });
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('study_problems', function (Blueprint $table) {
      $table->dropColumn('difficulty');
    });
  }
}
