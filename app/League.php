<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'league_id';
    protected $keyType = 'string';
    protected $table = 'leagues';
    
    public function teams()
    {
        return $this->hasMany('App\Team','team_league_id',$this->primaryKey);
    }

    public function matches()
    {
        return $this->hasMany('App\Match','match_league',$this->primaryKey);
    }
    /**
    * Muestra porcentajes de victoras locales, visitantes y empates de una liga
    * 
    * @param String $league
    * @return Array
    */
    public static function leaguesResults($league)
    {
        $matches = League::find($league)->matches->count();
        $win_local = League::find($league)->matches->where('match_final_res','=','H')->count();
        $win_away = League::find($league)->matches->where('match_final_res','=','A')->count();
        $draw_match = League::find($league)->matches->where('match_final_res','=','D')->count();

        $per_homewins = round(($win_local*100)/$matches,0);
        $per_awaywins = round(($win_away*100)/$matches,0);
        $per_draws = round(($draw_match*100)/$matches,0);

        return ['home' => $per_homewins,'away' => $per_awaywins,'draw' => $per_draws];
    }

}
