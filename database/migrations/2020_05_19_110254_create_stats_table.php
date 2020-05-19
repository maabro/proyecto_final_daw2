<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->string('stat_id',10)->primary();
            $table->string('stat_match',20);
            $table->string('stat_team',50);
            $table->integer('stat_shots')->unsigned();
            $table->integer('stat_shots_target')->unsigned();
            $table->integer('stat_corners')->unsigned();
            $table->integer('stat_fouls')->unsigned();
            $table->integer('stat_yellow_card')->unsigned();
            $table->integer('stat_red_card')->unsigned();

            $table->foreign('stat_team')->references('team_id')->on('teams');
            $table->foreign('stat_match')->references('match_id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
