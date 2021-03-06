<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class TeamController extends Controller
{
    /**
     * Muestra estadisticas de un equipo, llama a las disintas funciones y guarda
     * los resultados en un objeto equipo.
     *
     * @param  String  $team codigo del equipo.
     * @param  String  $leagues codigo de la liga.
     * @return \Illuminate\Http\Response
     */
    public function show($leagues,$team)
    {
        $team = Team::where('team_tag','=',$team)->first();
        $home_ft = $this->teamResHomeFt($team->team_id);
        $away_ft = $this->teamResAwayFt($team->team_id);
        $home_ht = $this->teamResHomeHt($team->team_id);
        $away_ht = $this->teamResAwayHt($team->team_id);
        $gl05 = $this->teamGoalsHt($team->league->league_id,$team->team_id,1);
        $gl15 = $this->teamGoalsHt($team->league->league_id,$team->team_id,2);
        $ft15 = $this->teamGoalsFt($team->league->league_id,$team->team_id,2);
        $ft25 = $this->teamGoalsFt($team->league->league_id,$team->team_id,3);
        $bts_ft = $this->teamBtsFt($team->league->league_id,$team->team_id);
        $bts_ht = $this->teamBtsHt($team->league->league_id,$team->team_id);
        $over_corner = $this->teamCorner($team->league->league_id,$team->team_id);
        $corner_for = $this->teamCornerFor($team->league->league_id,$team->team_id);
        $corner_against = $this->teamCornerAgainst($team->league->league_id,$team->team_id);
        $over_card = $this->teamCard($team->league->league_id,$team->team_id);
        $card_for = $this->teamCardFor($team->league->league_id,$team->team_id);
        $card_aga = $this->teamCardAgainst($team->league->league_id,$team->team_id);
        $goalavght = $this->teamGoalaverageHt($team->league->league_id,$team->team_id);
        $goalavgft = $this->teamGoalaverageFt($team->league->league_id,$team->team_id);
        Arr::add($team, 'home_ft', $home_ft);
        Arr::add($team, 'away_ft', $away_ft);
        Arr::add($team, 'home_ht', $home_ht);
        Arr::add($team, 'away_ht', $away_ht);
        Arr::add($team, 'gl05', $gl05);
        Arr::add($team, 'gl15', $gl15);
        Arr::add($team, 'ft15', $ft15);
        Arr::add($team, 'ft25', $ft25);
        Arr::add($team, 'btsft', $bts_ft);
        Arr::add($team, 'btsht', $bts_ht);
        Arr::add($team, 'over_corner', $over_corner);
        Arr::add($team, 'corner_for', $corner_for);
        Arr::add($team, 'corner_against', $corner_against);
        Arr::add($team, 'over_card', $over_card);
        Arr::add($team, 'card_for', $card_for);
        Arr::add($team, 'card_against', $card_aga);
        Arr::add($team, 'goalavght', $goalavght);
        Arr::add($team, 'goalavgft', $goalavgft);
        //dd($this->teamCardAgainst($team->league->league_id,$team->team_id));
             
        return view('pages.team', compact('team'));
    }
    /**
     * Calcula las victorias, empates y derrotas de un equipo cuando juega como local.
     * 
     * @param String $team variable con el id del equipo.
     * @return Array devuelve el numero de victorias, empates y derrotas.
     */
    private function teamResHomeFt($team)
    {
        $wins = DB::table('matches')->where('match_ht',$team)->where('match_final_res','H')->count();
        $draws = DB::table('matches')->where('match_ht',$team)->where('match_final_res','D')->count();
        $loses = DB::table('matches')->where('match_ht',$team)->where('match_final_res','A')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }
    /**
     * Calcula las victorias, empates y derrotas de un equipo cuando juega de visitante.
     * 
     * @param String $team variable con el id del equipo.
     * @return Array devuelve el numero de victorias, empates y derrotas.
     */
    private function teamResAwayFt($team)
    {
        $wins = DB::table('matches')->where('match_at',$team)->where('match_final_res','A')->count();
        $draws = DB::table('matches')->where('match_at',$team)->where('match_final_res','D')->count();
        $loses = DB::table('matches')->where('match_at',$team)->where('match_final_res','H')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }
    /**
     * Calcula las victorias, empates y derrotas de un equipo cuando juega de local en la media parte del partido.
     * 
     * @param String $team variable con el id del equipo.
     * @return Array devuelve el numero de victorias, empates y derrotas.
     */
    private function teamResHomeHt($team)
    {
        $wins = DB::table('matches')->where('match_ht',$team)->where('match_ht_res','H')->count();
        $draws = DB::table('matches')->where('match_ht',$team)->where('match_ht_res','D')->count();
        $loses = DB::table('matches')->where('match_ht',$team)->where('match_ht_res','A')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }
    /**
     * Calcula las victorias, empates y derrotas de un equipo cuando juega de visitante en la media parte del partido.
     * 
     * @param String $team variable con el id del equipo.
     * @return Array devuelve el numero de victorias, empates y derrotas.
     */
    private function teamResAwayHt($team)
    {
        $wins = DB::table('matches')->where('match_at',$team)->where('match_ht_res','A')->count();
        $draws = DB::table('matches')->where('match_at',$team)->where('match_ht_res','D')->count();
        $loses = DB::table('matches')->where('match_at',$team)->where('match_ht_res','H')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }
    /**
     * Calcula el porcentaje de over de goles de un equipo en ambas partes del partido.
     * 
     * @param String $team variable con el id del equipo.
     * @param String $league variable con el id de la liga.
     * @param Integer $n con el numero de goles, para el calculo de over.
     * @return Array devuelve el procentaje de goles para ambas partes del partido.
     */
    private function teamGoalsHt($league,$team,$n)
    {
        $ht = DB::table('matches')->where(function($t) use ($team){
            $t->where('match_ht',$team)
            ->orWhere('match_at',$team);
        })->whereRaw("(match_goals_home_ht+match_goals_away_ht) >= ".$n)->count();

        $ft = DB::table('matches')->where(function($t) use ($team){
            $t->where('match_ht',$team)
            ->orWhere('match_at',$team);
        })->whereRaw("((match_goals_home+match_goals_away)-(match_goals_home_ht+match_goals_away_ht)) >= ".$n)->count();

        return ['ht' => round(($ht*100)/totalMatches($league,$team)), 'ft' => round(($ft*100)/totalMatches($league,$team))];
    }
    /**
     * Calcula el porcentaje de over de goles para un equipo en un partido completo.
     * 
     * @param String $team variable con el id del equipo.
     * @param String $league variable con el id de la liga.
     * @param Integer $n con el numero de goles, para el calculo de over.
     * @return Array devuelve el procentaje de goles para el partido completo.
     */
    private function teamGoalsFt($league,$team,$n)
    {
        $ht = DB::table('matches')->where(function($t) use ($team){
            $t->where('match_ht',$team)
            ->orWhere('match_at',$team);
        })->whereRaw("(match_goals_home+match_goals_away) >= ".$n)->count();

        return ['ht' => round(($ht*100)/totalMatches($league,$team))];
    }
    /**
     * Calcula el goal average de un equipo en un partido completo,
     * tanto como cuando juega de local como de visitante.
     * 
     * @param String $league variable con el id de la liga.
     * @param String $team variable con el id del equipo.
     * @return Array devuelve los goles recibidos, realizados y el total de un equipo.
     */
    private function teamGoalaverageFt($league,$team)
    {
        $ht_matches = DB::table('matches')->where('match_ht','=', $team)->count();
        $at_matches = DB::table('matches')->where('match_at','=', $team)->count();
        $gf_db_home = DB::table('matches')->where('match_ht',$team)->sum('match_goals_home');
        $gf_db_away = DB::table('matches')->where('match_at',$team)->sum('match_goals_away');
        $ga_db_home = DB::table('matches')->where('match_ht',$team)->sum('match_goals_away');
        $ga_db_away = DB::table('matches')->where('match_at',$team)->sum('match_goals_home');

        $gf_home = round($gf_db_home/$ht_matches,2);
        $gf_away = round($gf_db_away/$at_matches,2);
        $ga_home = round($ga_db_home/$ht_matches,2);
        $ga_away = round($ga_db_away/$at_matches,2);
        $gf_total = round(($gf_db_home+$gf_db_away)/($ht_matches+$at_matches),2);
        $ga_total = round(($ga_db_home+$ga_db_away)/($ht_matches+$at_matches),2);

        return ['gf_home' => $gf_home, 'gf_away' => $gf_away, 'ga_home' => $ga_home, 'ga_away' => $ga_away, 'gf_total' => $gf_total, 'ga_total' => $ga_total];
    }
    /**
     * Calcula el goal average de un equipo en las dos partes del partido, 
     * tanto cuando juega como local como de visitante.
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array devuelve los goles recibidos, realizados y el total de un equipo
     */
    private function teamGoalaverageHt($league,$team)
    {
        $ht_matches = DB::table('matches')->where('match_ht','=', $team)->count();
        $at_matches = DB::table('matches')->where('match_at','=', $team)->count();
        $gf_db_home = DB::table('matches')->where('match_ht',$team)->sum('match_goals_home_ht');
        $gf_db_away = DB::table('matches')->where('match_at',$team)->sum('match_goals_away_ht');
        $ga_db_home = DB::table('matches')->where('match_ht',$team)->sum('match_goals_away_ht');
        $ga_db_away = DB::table('matches')->where('match_at',$team)->sum('match_goals_home_ht');

        $gf_home = round($gf_db_home/$ht_matches,2);
        $gf_away = round($gf_db_away/$at_matches,2);
        $ga_home = round($ga_db_home/$ht_matches,2);
        $ga_away = round($ga_db_away/$at_matches,2);
        $gf_total = round(($gf_db_home+$gf_db_away)/($ht_matches+$at_matches),2);
        $ga_total = round(($ga_db_home+$ga_db_away)/($ht_matches+$at_matches),2);

        return ['gf_home' => $gf_home, 'gf_away' => $gf_away, 'ga_home' => $ga_home, 'ga_away' => $ga_away, 'gf_total' => $gf_total, 'ga_total' => $ga_total];
    }
    /**
     * Calcula el porcentaje de ambos marcan o ambos no marcan de un equipo para un partido completo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array devuelve el porcentaje de ambos marcan y ambos no marcan
     */
    private function teamBtsFt($league,$team)
    {
        $matches = totalMatches($league,$team);
        $yes = DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
            $m->where('match_ht',$team)
                ->orWhere('match_at',$team);
        })->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();
        $no = DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
            $m->where('match_ht',$team)
                ->orWhere('match_at',$team);
        })->where('match_goals_home','<=',0)->where('match_goals_away','<=',0)->count();
        $per_yes = round(($yes*100)/$matches);
        $per_no = round(($no*100)/$matches);

        return ['yes' => $per_yes, 'no' => $per_no];
    }
    /**
     * Calcula el porcentaje de ambos marcan de un equipo en cada parte del partido
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array devuelve el porcentaje de ambos marcan y ambos no marcan
     */
    private function teamBtsHt($league,$team)
    {
        $matches = totalMatches($league,$team);
        $yes = DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
            $m->where('match_ht',$team)
                ->orWhere('match_at',$team);
        })->where('match_goals_home_ht','>',0)->where('match_goals_away_ht','>',0)->count();
        $no = DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
            $m->where('match_ht',$team)
                ->orWhere('match_at',$team);
        })->where('match_goals_home_ht','<=',0)->where('match_goals_away_ht','<=',0)->count();
        $per_yes = round(($yes*100)/$matches);
        $per_no = round(($no*100)/$matches);

        return ['yes' => $per_yes, 'no' => $per_no];
    }
    /**
     * Calcula los corners totales en un partido de un equipo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array $corners devuelve el nombre y el porcentaje de corners
     */
    private function teamCorner($league,$team)
    {
        $matches = totalMatches($league,$team);
        $corners = collect([]);
        $z = 7.5;
        for($m=8; $m <= 14; $m++) {
            $corner = cornersTeam($team,$m);
            $per_corner = round(($corner*100)/$matches);
            $corners->push(['name' => 'Over '.$z, 'over' => $per_corner]);
            $z++;
        }

        return $corners;
    }
    /**
     * Calcula los corners que ha recibido un equipo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array $corners devuelve el nombre y el porcentaje de corners
     */
    private function teamCornerFor($league,$team)
    {
        $matches = totalMatches($league,$team);
        $corners = collect([]);
        $n = 2.5;
        for($m=3;$m<=9;$m++){
            $corner = DB::table('stats')->where('stat_team',$team)->where('stat_corners','>=',$m)->count();
            $per_corner = round(($corner*100)/$matches);
            $corners->push(['name' => 'Over '.$n, 'over' => $per_corner]);
            $n++;
        }   
        return $corners;
    }
    /**
     * Calcula los corners que han hecho los oponentes del equipo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array $corners devuelve el nombre y el porcentaje de corners
     */
    private function teamCornerAgainst($league,$team)
    {
        $matches = totalMatches($league,$team);
        $corners = collect([]);
        $n = 2.5;
        for($m=3;$m<=9;$m++){
            $corner = DB::table('stats')->whereIn('stat_match', function($query) use ($team){
                $query->select('stat_match')->from('stats')->where('stat_team',$team);
            })->where('stat_team','!=',$team)->where('stat_corners','>=',$m)->count();    
            $per_corner = round(($corner*100)/$matches);
            $corners->push(['name' => 'Over '.$n, 'over' => $per_corner]);
            $n++;
        }
        return $corners;
    }
    /**
     * Calcula las tarjetas totales en un partido de un equipo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array $cards devuelve el nombre y el porcentaje de tarjetas
     */
    private function teamCard($league,$team)
    {
        $matches = totalMatches($league,$team);
        $cards = collect([]);
        $z = 0.5;
        for($m=1; $m <= 7; $m++) {
            $card = cardsTeam($team,$m);
            $per_card = round(($card*100)/$matches);
            $cards->push(['name' => 'Over '.$z, 'over' => $per_card]);
            $z++;
        }
        return $cards;
    }
    /**
     * Calcula las tarjetas que ha recibido un equipo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array $cards devuelve el nombre y el porcentaje de tarjetas
     */
    private function teamCardFor($league,$team)
    {
        $matches = totalMatches($league,$team);
        $cards = collect([]);
        $n = 0.5;
        for($m=1;$m<=7;$m++){
            $card = DB::table('stats')->where('stat_team',$team)->whereRaw("(stat_yellow_card+stat_red_card) >=".$m)->count();
            $per_card = round(($card*100)/$matches);
            $cards->push(['name' => 'Over '.$n, 'over' => $per_card]);
            $n++;
        }   
        return $cards;
    }
    /**
     * Calcula las trajetas que han recibido los oponentes del equipo
     * 
     * @param String $league variable con el id de la liga
     * @param String $team variable con el id del equipo
     * @return Array $cards devuelve el nombre y el porcentaje de tarjetas
     */
    private function teamCardAgainst($league,$team)
    {
        $matches = totalMatches($league,$team);
        $cards = collect([]);
        $n = 0.5;
        for($m=1;$m<=7;$m++){
            $card = DB::table('stats')->whereIn('stat_match', function($query) use ($team){
                $query->select('stat_match')->from('stats')->where('stat_team',$team);
            })->where('stat_team','!=',$team)->whereRaw("(stat_yellow_card+stat_red_card) >=".$m)->count();    
            $per_card = round(($card*100)/$matches);
            $cards->push(['name' => 'Over '.$n, 'over' => $per_card]);
            $n++;
        }
        return $cards;
    }
}