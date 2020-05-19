<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonTeam extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $table = 'season_teams';
}
