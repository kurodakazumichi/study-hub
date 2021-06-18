<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToStudiesTable extends Migration
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
      // order_noの後にlinkカラムを追加
      $table->after('order_no', function($table) {
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
    Schema::table('studies', function (Blueprint $table) {
      $table->dropColumn('link');
    });
  }
}
