<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'season_id';
    protected $keyType = 'string';
    protected $table = 'seasons';

    public function leagues()
    {
        return $this->belongsToMany('App\League','league_seasons',$this->primaryKey,'league_id');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team','season_teams',$this->primaryKey,'team_id');
    }

    public function matches() {
        return $this->hasMany('App\Match','match_season',$this->primaryKey);
    }
}
