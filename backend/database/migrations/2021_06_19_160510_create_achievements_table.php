<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsTable extends Migration
{
  /**
    * Run the migrations.
    *
    * @return void
    */
  public function up()
  {
    Schema::create('achievements', function (Blueprint $table) {
      $table->id();
      $table->integer('category_id');
      $table->integer('variety_id');
      $table->string('title');
      $table->string('condition');
      $table->tinyInteger('difficulty');
      $table->integer('note_id')->nullable();
      $table->timestamp('achievement_at')->nullable();
      $table->timestamps();
    });
  }

  /**
    * Reverse the migrations.
    *
    * @return void
    */
  public function down()
  {
    Schema::dropIfExists('achievements');
  }
}
