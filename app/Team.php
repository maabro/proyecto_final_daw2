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

    /*public function league()
    {
        return $this->belongsTo('App\League','team_league_id',$this->primaryKey);
    }*/
    
    public function homeTeamMatch()
    {
        return $this->hasMany('App\Match','match_ht',$this->primaryKey);
    }

    public function awayTeamMatch()
    {
        return $this->hasMany('App\Match','match_at',$this->primaryKey);
    }

    public function seasonsTeams()
    {
        return $this->belongsToMany('App\Season','season_teams',$this->primaryKey,'season_id');
    }

    public function statsTeams()
    {
        return $this->hasMany('App\Stat','stat_team',$this->primaryKey);
    }
}
