<?php

namespace App\Http\Controllers;

use App\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

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
            $g1 = $this->leaguesGoals($league->league_id,1);
            $g2 = $this->leaguesGoals($league->league_id,2);
            $g3 = $this->leaguesGoals($league->league_id,3);
            $s->push(['id' => $league->league_id, 'bts' => $b, 'res' => $r, 'o0.5' => $g1, 'o1.5' => $g2, 'o2.5' => $g3]);             
        }
        
        return view('pages.leagues', ['leagues' => $leagues, 'results' => $s]);
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
     * 
     */
    private function leaguesGoals($league,$n)
    {
        $matches = League::find($league)->matches->count();
        $goals = DB::table('matches')->where('match_league','=',$league)->whereRaw("(match_goals_home+match_goals_away) >= ".$n)->count();
        $per_goals = round(($goals*100)/$matches);

        return $per_goals;
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
            $mat = teamsResultsMatch($lg->league_id,$team->team_id);
            $gf = $this->teamsGf($lg->league_id,$team->team_id);
            $ga = $this->teamsGa($lg->league_id,$team->team_id);
            $cs = $this->teamsCs($lg->league_id,$team->team_id);
            $fts = $this->teamsFts($lg->league_id,$team->team_id);
            $cd = $this->teamsCards($team->team_id);
            $bts = $this->teamsBts($lg->league_id,$team->team_id);
            $corner = $this->teamsCorner($team->team_id);
            $avg = $this->teamsAvg($lg->league_id,$team->team_id);
            $t = $teams->find($team->team_id);           
            Arr::add($t, 'point', $res);
            Arr::add($t, 'matches', $mat);
            Arr::add($t, 'goals_gf', $gf);
            Arr::add($t, 'goals_ga', $ga);
            Arr::add($t, 'clean_sheets', $cs);
            Arr::add($t, 'fts', $fts);
            Arr::add($t, 'cards', $cd);
            Arr::add($t, 'bts', $bts);
            Arr::add($t, 'corners', $corner);
            Arr::add($t, 'avg', $avg);
        }
        $teams = $teams->sortByDesc('point');
        //dd();
        return view('pages.league', ['lg' => $lg, 'teams' => $teams, 'count' => $count]);
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
     * Calcula los puntos de los equipos en la clasificación
     * 
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
    /**
     * Calcula los goles que ha marcado un equipo
     * 
     * @param String $league variable con la id de la liga
     * @param String $team variable con la id del equipo
     * @return Integer $goals variable con la suma de goles de un equipo como visitante y local
     */
    private function teamsGf($league,$team)
    {
        $goals_local = League::find($league)->matches->where('match_ht',$team)->sum('match_goals_home');
        $goals_away = League::find($league)->matches->where('match_at',$team)->sum('match_goals_away');
        $goals = $goals_local+$goals_away;

        return $goals;
    }
    /**
     * Calcula los goles que ha recibido un equipo
     * 
     * @param String $league variable con la id de la liga
     * @param String $team variable con la id del equipo
     * @return Integer $goals variable con la suma de goles que ha recibido el equipo
     */
    private function teamsGa($league,$team)
    {
        $goals_local = League::find($league)->matches->where('match_ht',$team)->sum('match_goals_away');
        $goals_away = League::find($league)->matches->where('match_at',$team)->sum('match_goals_home');
        $goals = $goals_local+$goals_away;

        return $goals;        
    }
    /**
     * Calcula los partidos de un equipo que no ha recibido goles
     * 
     * @param String $league variable con la id de la liga
     * @param String $team variable con la id del equipo
     * @return Float $cs variable con el total de partidos con la porteria a cero
     */
    private function teamsCs($league,$team)
    {
        $matches = totalMatches($league,$team);
        $cs_local =  League::find($league)->matches->where('match_ht',$team)->where('match_final_res','!=',"")
                        ->where('match_goals_away',0)->count();
        $cs_away =  League::find($league)->matches->where('match_at',$team)->where('match_final_res','!=',"")
                        ->where('match_goals_home',0)->count();
        $cs = round((($cs_local+$cs_away)*100)/$matches);
        return $cs;
    }
    /**
     * Calcula los partidos que el equipo no ha marcado
     * 
     * @param String $league variable con la id de la liga
     * @param String $team variable con la id del equipo
     * @return Float $fts variable con el total de partidos que un equipo no ha marcado
     */
    private function teamsFts($league,$team)
    {
        $matches = totalMatches($league,$team);
        $fts_local =  League::find($league)->matches->where('match_ht',$team)->where('match_final_res','!=',"")
                        ->where('match_goals_home',0)->count();
        $fts_away =  League::find($league)->matches->where('match_at',$team)->where('match_final_res','!=',"")
                        ->where('match_goals_away',0)->count();
        $fts = round((($fts_local+$fts_away)*100)/$matches);
        return $fts;
    }
    /**
     * Calcaula las tarjetas amarillas y rojas de un equipo
     * 
     * @param String $team variable con la id del equipo
     * @return Array con la cantidad de tarjetas
     */
    private function teamsCards($team)
    {
        $matches = DB::table('stats')->where('stat_team',$team)->count();
        $card_yellow = DB::table('stats')->where('stat_team',$team)->sum('stat_yellow_card');
        $card_red = DB::table('stats')->where('stat_team',$team)->sum('stat_red_card');
        $avg_card_yellow = round($card_yellow/$matches,2);
        $avg_card_red = round($card_red/$matches,2);
        return ['yellow' => $avg_card_yellow, 'red' => $avg_card_red];
    }
    /**
     * Calcula el porcentaje de "ambos marcan" de un equipo
     * 
     * @param String $league variable con la id de la liga
     * @param String $team variable con la id del equipo
     * @return Float $per_bts variable con el porcentaje de bts de un equipo
     */
    private function teamsBts($league,$team)
    {
        $matches = totalMatches($league,$team);
        $bts = DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
            $m->where('match_ht',$team)
                ->orWhere('match_at',$team);
        })->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();
        $per_bts = round(($bts*100)/$matches);

        return $per_bts;
    }
    /**
     * Calcula la media de corners de un equipo
     * 
     * @param String $team variable con la id del equipo
     * @return Float $avg_corners variable devuele la media de corners de un equipo
     */
    private function teamsCorner($team)
    {
        $matches = DB::table('stats')->where('stat_team',$team)->count();
        $corners = DB::table('stats')->where('stat_team',$team)->sum('stat_corners');
        $avg_corners = round($corners/$matches,2);
        return $avg_corners;
    }
    /**
     * Calcula la media de goles de un equipo
     * 
     * @param String $league variable con la id de la liga
     * @param String $team variable con la id del equipo
     * @return Float $avg devuelve la media de goles de un equipo
     */
    private function teamsAvg($league,$team)
    {
        $matches = totalMatches($league,$team);
        $home = $this->teamsGf($league,$team);
        $away = $this->teamsGa($league,$team);
        $avg = round(($home+$away)/$matches,2);
        return $avg;
    }
}