<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvalAndCommentToStudiesTable extends Migration
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
      $table->after('note_id', function($table) {
        $table->integer('eval')->default(0);
        $table->string('comment')->nullable();
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
      $table->dropColumn('eval');
      $table->dropColumn('comment');
    });
  }
}
