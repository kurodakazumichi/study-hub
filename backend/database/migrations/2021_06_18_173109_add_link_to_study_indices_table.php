<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToStudyIndicesTable extends Migration
{
  /**
    * Run the migrations.
    *
    * @return void
    */
  public function up()
  {
    Schema::table('study_indices', function (Blueprint $table) {
      $table->after('note_id', function ($table) {
        $table->string('link')->nullable();
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
    Schema::table('study_indices', function (Blueprint $table) {
      $table->dropColumn('link');
    });
  }
}
