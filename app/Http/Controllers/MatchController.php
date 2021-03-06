<?php

namespace App\Http\Controllers;

use App\Match;
use App\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class MatchController extends Controller
{
    /**
     * Muestra la lista de ligas en la vista.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = Match::where('match_final_res','=',"")->get();                
        $leagues = DB::table('leagues')->get();        
        $mt = collect([]);
        foreach($leagues as $l){
            $m = $matches->where('match_league',$l->league_id);
            if($m->count() > 0){
                $mt->push(['name' => $l->league_name, 'flag' => $l->league_country_flag, 
                'country' => $l->league_country, 'img' => $l->league_img, 'matches' => $m]);
            }            
        }
        return view('pages.home',['league' => $mt]);
    }
    /**
     * Muestra un partido en la vista.
     * 
     * @param String $match variable con la id de partido
     * @return \Illuminate\Http\Response
     */
    public function show($match)
    {
        $mt = $this->matchContent($match);
        return view('pages.match', compact('mt'));
    }
    /**
     * Llama al resto de funciones que añaden las estadisticas al partido.
     * 
     * @param String $m variable con la id del partido.
     * @return Array $mt devuele el objeto partido.
     */
    private function matchContent($m)
    {
        $mt = Match::find($m);
        $bts = $this->bothTeamscore($mt->homeTeam->team_id, $mt->awayTeam->team_id);  
        $corner = $this->cornersTable($mt->league->league_id,$mt->homeTeam->team_id,$mt->awayTeam->team_id);
        $card = $this->cardsTable($mt->league->league_id,$mt->homeTeam->team_id,$mt->awayTeam->team_id);
        $goals = $this->goalTable($mt->homeTeam->team_id,$mt->awayTeam->team_id);
        $avg = $this->avgTable($mt->homeTeam->team_id,$mt->awayTeam->team_id);
        $overs = $this->overgoalsTable($mt->homeTeam->team_id,$mt->awayTeam->team_id);
        Arr::add($mt, 'corners', $corner);
        Arr::add($mt, 'cards', $card);
        Arr::add($mt, 'bts', $bts);
        Arr::add($mt, 'goals', $goals);
        Arr::add($mt, 'avg', $avg);
        Arr::add($mt, 'overs', $overs);
        
        return $mt;
    }
    /**
     * Calcula los parametros de la tablas de media de over de goles.
     * 
     * @param String $home variable con la id del equipo local.
     * @param String $away variable con la id del equipo visitante.
     * @return Array $overs resultado de los goles.
     */
    private function overgoalsTable($home,$away)
    {
        $ht_matches = Match::where('match_ht','=', $home)->where('match_final_res','!=','')->count();
        $at_matches = Match::where('match_at','=', $away)->where('match_final_res','!=','')->count();
        $overs = collect([]);
        for($n=2;$n<=3;$n++){
            $db_over = DB::table('matches')->where(function($o) use ($home,$away) {
                $o->where('match_ht',$home)
                    ->orWhere('match_at',$away);
            })->whereRaw("(match_goals_home+match_goals_away) >= ".$n)->where('match_final_res','!=','')->count();
            $over = round(($db_over*100)/($ht_matches+$at_matches));
            $overs->push(['name'.$n => $over]);
        }
        return $overs;       
    }
    /**
     * Calcula los over de goles de la tabla de "Over goals match".
     * 
     * @param String $home variable con la id del equipo local.
     * @param String $away variable con la id del equipo visitante.
     * @param Array $goals devuelve el nombre, el porcentaje de goles del local y del visitante.
     */
    private function goalTable($home,$away)
    {
        $ht_matches = Match::where('match_ht','=', $home)->where('match_final_res','!=','')->count();
        $at_matches = Match::where('match_at','=', $away)->where('match_final_res','!=','')->count();

        $goals = collect([]);
        $m = 0.5;
        for($n = 1; $n <= 4; $n++){
            $db_home = DB::table('matches')->where('match_ht',$home)
                ->whereRaw("(match_goals_home+match_goals_away) >= ".$n)
                ->where('match_final_res','!=','')->count();
            $db_away = DB::table('matches')->where('match_at',$away)
                ->whereRaw("(match_goals_home+match_goals_away) >= ".$n)
                ->where('match_final_res','!=','')->count();
            
            $ho_goals = round(($db_home*100)/$ht_matches);
            $aw_goals = round(($db_away*100)/$at_matches);

            $goals->push(['name' => 'Over '.$m, 'home' => $ho_goals, 'away' => $aw_goals]);
            $m++;
        }
        return $goals;        
    }
    /**
     * Calcula la media de goles por partido.
     * 
     * @param String $home variable con la id del equipo local.
     * @param String $away variable con la id del equipo visitante.
     * @return Float $avg media de goles de ambos equipos.
     */
    private function avgTable($home,$away)
    {   
        $matches = DB::table('matches')->where(function($m) use ($home,$away){
            $m->where('match_ht',$home)
                ->orWhere('match_at',$away);
        })->where('match_final_res','!=','')->count();
        $hTeam_home_goals = Match::where('match_ht',$home)->where('match_final_res','!=','')->sum('match_goals_home');
        $hTeam_away_goals = Match::where('match_at',$home)->where('match_final_res','!=','')->sum('match_goals_away');
        $aTeam_home_goals = Match::where('match_ht',$away)->where('match_final_res','!=','')->sum('match_goals_home');
        $aTeam_away_goals = Match::where('match_at',$away)->where('match_final_res','!=','')->sum('match_goals_away');

        $avg = round(($hTeam_home_goals+$hTeam_away_goals+$aTeam_home_goals+$aTeam_away_goals)/$matches,2);
        
        return $avg;
    }
    /**
     * Calcula los porcentajes de ambos equipos marcan, tanto del local como del visitante.
     * 
     * @param String $home variable con la id del equipo local.
     * @param String $away variable con la id del equipo visitante.
     * @return Array $both array con los datos de ambos marcan de cada equipo y de los dos juntos.
     */
    private function bothTeamscore($home, $away)
    {
        $bts_ht_matches = Match::where('match_ht','=', $home)->count();
        $bts_at_matches = Match::where('match_at','=', $away)->count();
        $bts_matches = Match::where(function($query) use ($home,$away){
            $query->whereIn('match_ht',[$home,$away])
                    ->orWhere(function($query2) use ($home,$away){
                        $query2->whereIn('match_at',[$home,$away]);
                    });
        })->count();

        $bts = Match::where(function($query1) use ($home,$away){
            $query1->whereIn('match_ht',[$home,$away])
                    ->orWhere(function($query2) use ($home,$away){
                        $query2->whereIn('match_at',[$home,$away]);
                    });
        })->where(function($query3){
            $query3->where('match_goals_home','>',0)
                    ->where('match_goals_away','>',0);
        })->count();

        $bts_home_yes = Match::where('match_ht','=', $home)->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();
        $bts_away_yes = Match::where('match_at','=', $away)->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();
        $bts_home_no = Match::where('match_ht','=', $home)->where(function($h){
            $h->where('match_goals_home',0)
                ->orWhere('match_goals_away',0);
        })->count();
        $bts_away_no = Match::where('match_at','=', $away)->where(function($a){
            $a->where('match_goals_home',0)
                ->orWhere('match_goals_away',0);
        })->count();

        $home_yes = round(($bts_home_yes*100)/$bts_ht_matches);
        $away_yes = round(($bts_away_yes*100)/$bts_at_matches);
        $home_no = round(($bts_home_no*100)/$bts_ht_matches);
        $away_no = round(($bts_away_no*100)/$bts_at_matches);
        $bts_per = round(($bts*100)/$bts_matches);

        $both = collect([]);
        Arr::add($both, 'bts_per', $bts_per);
        Arr::add($both, 'home_yes', $home_yes);
        Arr::add($both, 'home_no', $home_no);
        Arr::add($both, 'away_yes', $away_yes);
        Arr::add($both, 'away_no', $away_no);

        return $both;
    }
    /**
     * Calcula la tabla de tarjetas de ambos equipos y la media.
     * 
     * @param String $league variable con la id de la liga.
     * @param String $home variable con la id del equipo local.
     * @param String $away variable con la id del equipo visitante.
     * @return Array $cards devuelve el nombre, el numero de tarjetas del local, del visitante y las media.
     */
    private function cardsTable($league,$home,$away)
    {
        $mt_home = totalMatches($league,$home);
        $mt_away = totalMatches($league,$away);
        
        $cards = collect([]);
        $n = 1.5;
        for($m=2; $m <= 8; $m++) {
            $car_home = cardsTeam($home,$m);
            $car_away = cardsTeam($away,$m);
            $per_card_home = round(($car_home*100)/$mt_home);
            $per_card_away = round(($car_away*100)/$mt_away);
            $avg_card = round((($car_home+$car_away)*100)/($mt_home+$mt_away));
            $cards->push(['name' => 'Over '.$n, 'home' => $per_card_home, 'away' => $per_card_away, 'avg' => $avg_card]);
            $n++;
        }
        return $cards;
    }
    /**
     * Calcula la tabla de corners de ambos equipos y la media.
     * 
     * @param String $league variable con la id de la liga.
     * @param String $home variable con la id del equipo local.
     * @param String $away variable con la id del equipo visitante.
     * @return Array $corners devuelve el nombre, los corners de local, de visitante y la media.
     */
    private function cornersTable($league,$home,$away)
    {
        $mt_home = totalMatches($league,$home);
        $mt_away = totalMatches($league,$away);

        $corners = collect([]);
        $n = 7.5;
        for($m=8; $m <= 14; $m++) {
            $cor_home = cornersTeam($home,$m);
            $cor_away = cornersTeam($away,$m);
            $per_corner_home = round(($cor_home*100)/$mt_home);
            $per_corner_away = round(($cor_away*100)/$mt_away);
            $avg_corner = round((($cor_home+$cor_away)*100)/($mt_home+$mt_away));
            $corners->push(['name' => 'Over '.$n, 'home' => $per_corner_home, 'away' => $per_corner_away, 'avg' => $avg_corner]);
            $n++;
        }
        return $corners;
    }
}