<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDifficultyToStudiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('studies', function (Blueprint $table) {
      $table->after('comment', function($table) {
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
    Schema::table('studies', function (Blueprint $table) {
      $table->dropColumn('difficulty');
    });
  }
}
