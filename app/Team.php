<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class Team extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'team_id';
    protected $keyType = 'string';
    protected $table = 'teams';

    public function league()
    {
        return $this->belongsTo('App\League','team_league_id','league_id');
    }
    
    public function homeTeamMatch()
    {
        return $this->hasMany('App\Match','match_ht',$this->primaryKey);
    }

    public function awayTeamMatch()
    {
        return $this->hasMany('App\Match','match_at',$this->primaryKey);
    }

    public function statsTeams()
    {
        return $this->hasMany('App\Stat','stat_team',$this->primaryKey);
    }
}
