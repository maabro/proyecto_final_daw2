<?php

namespace App\Http\Controllers;

use App\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = League::all();

        $s = collect([]);
        foreach($leagues as $league){
            $r = $this->leaguesResults($league->league_id);
            $b = $this->leaguesBts($league->league_id);
            $s->push(['id' => $league->league_id, 'bts' => $b, 'res' => $r]);             
        }
        
        return view('pages.leagues', ['leagues' => $leagues, 'results' => $s]);
    }
    /**
     * Muestra porcentajes de victoras locales, visitantes y empates de una liga
     * 
     * @param String $league
     * @return Array
     */
    private function leaguesResults($league)
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
    /**
     * Calcula el porcentaje de partidos que ambos equipos marcan de una liga
     * 
     * @param String $league
     * @return Float $per_bts
     */
    private function leaguesBts($league)
    {
        $matches = League::find($league)->matches->count();
        $bts = League::find($league)->matches->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();
        $per_bts = round(($bts*100)/$matches);

        return $per_bts;
    }
    /**
     * Display the specified resource.
     *
     * @param  String  $league
     * @return \Illuminate\Http\Response
     */
    public function show($league)
    {
        $lg = DB::table('leagues')->where('league_tag','=',$league)->first();  
        $teams = League::find($lg->league_id)->teams;
        $count = 1;
        $points = collect([]);
        foreach($teams as $team){
            $res = $this->teamScore($team->team_id);
            $points->push(['team_id' => $team->team_id, 'point' => $res]);
        }

        return view('pages.league', compact('lg','teams','count', 'points'));
    }
    /**
     * Calcula los puntos de los equipos en la clasificación
     * @param String $team
     * @return Integer $points
     */
    private function teamScore($team)
    {
        $home_wins = DB::table('matches')->where('match_ht','=',$team)->where('match_final_res','=','H')->count()*3;
        $away_wins = DB::table('matches')->where('match_at','=',$team)->where('match_final_res','=','A')->count()*3;
        $draws = DB::table('matches')->where(function($query) use ($team){
            $query->where('match_ht','=',$team)
            ->orWhere('match_at','=',$team);
        })->where('match_final_res','=','D')->count();

        $points = $home_wins + $away_wins + $draws;

        return $points;
    }
}