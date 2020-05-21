<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'match_id';
    protected $keyType = 'string';
    protected $table = 'matches';

    public function homeTeam()
    {
        return $this->belongsTo('App\Team','match_ht','team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo('App\Team','match_at','team_id');
    }

    public function statsMatch()
    {
        return $this->hasMany('App\Stat','stat_match',$this->primaryKey);
    }

    public function league()
    {
        return $this->belongsTo('App\League','match_league','league_id');
    }

}
