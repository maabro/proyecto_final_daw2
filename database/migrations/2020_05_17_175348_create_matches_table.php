<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->string('match_id',10)->primary();
            //$table->string('match_league',20);
            $table->string('match_season',20);
            $table->date('match_day');
            $table->time('match_hour');
            $table->string('match_ht',50);
            $table->string('match_at',50);
            $table->integer('match_goals_home')->unsigned();
            $table->integer('match_goals_away')->unsigned();
            $table->char('match_final_res',1);
            $table->integer('match_goals_home_ht')->unsigned();
            $table->integer('match_goals_away_ht')->unsigned();
            $table->char('match_ht_res',1);

            $table->foreign('match_ht')->references('team_id')->on('teams');
            $table->foreign('match_at')->references('team_id')->on('teams');
            $table->foreign('match_season')->references('season_id')->on('seasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
