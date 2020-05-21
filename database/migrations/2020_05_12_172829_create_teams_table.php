<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->string('team_id',10)->primary();
            $table->string('team_img',20);
            $table->string('team_name',50);
            $table->string('team_slug',50);
            $table->string('team_league_id',5);
            $table->string('team_tag',50);
            
            $table->foreign('team_league_id')->references('league_id')->on('leagues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
