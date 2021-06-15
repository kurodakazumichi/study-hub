<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('study_indices', function (Blueprint $table) 
      {
        $table->id();
        $table->integer('study_id');
        $table->tinyInteger('mastery')->default(0);
        $table->tinyInteger('major');
        $table->tinyInteger('minor')->nullable();
        $table->tinyInteger('micro')->nullable();;
        $table->string('title');
        $table->string('comment')->default('');
        $table->integer('note_id')->nullable();
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
      Schema::dropIfExists('study_indeces');
    }
}
