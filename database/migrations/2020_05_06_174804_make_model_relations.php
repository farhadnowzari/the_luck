<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeModelRelations extends Migration
{

    public function up()
    {
        Schema::create('round_judge', function(Blueprint $table) {
            $table->unsignedInteger('round_id')->index();
            $table->unsignedInteger('judge_id')->index();

            $table->primary(['round_id', 'judge_id']);
            $table->foreign('round_id')->references('id')->on('rounds');
            $table->foreign('judge_id')->references('id')->on('judges');
        });

        Schema::create('round_contestant', function(Blueprint $table) {
            $table->unsignedInteger('round_id')->index();
            $table->unsignedInteger('judge_id')->index();
            $table->boolean('sick');
            $table->float('contestant_score');
            $table->float('final_score');

            $table->primary(['round_id', 'judge_id']);
        });

        Schema::create('contestant_genre', function(Blueprint $table) {
            $table->unsignedInteger('contestant_id')->index();
            $table->unsignedInteger('genre_id')->index();
            $table->float('strength_score');

            $table->foreign('contestant_id')->references('id')->on('contestants')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('contestant_genre');
        Schema::dropIfExists('round_contestant');
        Schema::dropIfExists('round_judge');
    }
}
