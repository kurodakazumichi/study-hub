<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteIdToStudiesTable extends Migration
{
  /**
    * Run the migrations.
    *
    * @return void
    */
  public function up()
  {
    Schema::table('studies', function (Blueprint $table) 
    {
      // linkの後にlinkカラムを追加
      $table->after('link', function($table) {
        $table->integer('note_id')->nullable();
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
      $table->dropColumn('note_id');
    });
  }
}
