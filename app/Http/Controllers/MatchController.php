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
     * Display a listing of the resource.
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
        //dd($mt);
        return view('pages.home',['league' => $mt]);
    }

    public function show($match)
    {
        //dd($match);
        $mt = Match::find($match);  
        //$mt->awayTeam->team_id,$mt->homeTeam->team_id
        $ht = $mt->homeTeam->team_id;
        $goals = $this->goalsTable($ht);
        $bts = $this->bothTeamscore($mt->homeTeam->team_id, $mt->awayTeam->team_id);
        //var_dump($cards);
        dd($this->cardsTable('SP1','T225','T226'));  

        return view('pages.match', compact('mt'));
    }

    private function matchTeams($league,$home)
    {
        $match_teams = collect([]);
        for($n = 1; $n < 5; $n++){
            $h = $this->goalTable($league,$home,$n);
            Arr::add($match_teams, 'h_over_'.$n, $h);
            
        }
        //dd($match_teams);
        return $match_teams;
    }

    private function goalTable($league,$team,$n)
    {
        $goal = DB::table('matches')->where(function($t) use ($team){
            $t->where('match_ht',$team)
            ->orWhere('match_at',$team);
        })->whereRaw("(match_goals_home+match_goals_away) >= ".$n)->count();

        return ['goal'.$n => round(($goal*100)/totalMatches($league,$team))];        
    }


    private function goalsTable($team)
    {   
        /**
         * @var int
         */
        $h = 0;
        $a = 0;
        $home_goals = Match::where('match_ht','=',$team)->where('match_final_res','!=','')->get();
        
        foreach($home_goals as $hg){
            $h += $hg->match_goals_home;
        }

        $away_goals = Match::where('match_at','=',$team)->where('match_final_res','!=','')->get();
        
        foreach($away_goals as $ag){
            $a += $ag->match_goals_away;
        }
        $total = $a + $h;
        
        /**
         * @var 
         */
        $nlocalmatch = $home_goals->count();
        $nawaymatch = $away_goals->count();
        
        /**
         * Variables promedio
         * @var float
         */
        $avergo_local = round($h/$nlocalmatch,2);
        $avergo_away = round($a/$nawaymatch,2);
        $avergo_total = round($total/($nlocalmatch + $nawaymatch),2);
        
        /**
         * Variables porcentajes
         * @var float
         */
        // $home_per = ($h *100)/$total;
        // $away_per = ($h *100)/$total;

        $goals = Arr::add([], 'home', $h);
        $goals = Arr::add($goals, 'away', $a);
        $goals = Arr::add($goals, 'total', $total);
        $goals = Arr::add($goals, 'avergo_local',$avergo_local);
        $goals = Arr::add($goals, 'avergo_away',$avergo_away);
        $goals = Arr::add($goals, 'avergo_total',$avergo_total);

        return $goals;
    }

    private function bothTeamscore($home, $away)
    {
        //dd($home);
        $bts = Match::where(function($query1) use ($home,$away){
            $query1->whereIn('match_ht',[$home,$away])
                    ->orWhere(function($query2) use ($home,$away){
                        $query2->whereIn('match_at',[$home,$away]);
                    });

        })->where(function($query3){
            $query3->where('match_goals_home','>',0)
                    ->where('match_goals_away','>',0);
        })->count();

        $bts_home = Match::where('match_ht','=', $home)->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();
        $bts_away = Match::where('match_at','=', $away)->where('match_goals_home','>',0)->where('match_goals_away','>',0)->count();

        $bts_ht_matches = Match::where('match_ht','=', $home)->count();
        $bts_at_matches = Match::where('match_at','=', $away)->count();

        $bts_matches = Match::where(function($query) use ($home,$away){
            $query->whereIn('match_ht',[$home,$away])
                    ->orWhere(function($query2) use ($home,$away){
                        $query2->whereIn('match_at',[$home,$away]);
                    });
        })->count();

        $bts_htper = round(($bts_home*100)/$bts_ht_matches, 2);
        $bts_atper = round(($bts_away*100)/$bts_at_matches, 2);
        $bts_per = round(($bts*100)/$bts_matches, 2);

        $both = Arr::add([], 'bts_per', $bts_per);
        $both = Arr::add($both, 'bts_htper', $bts_htper);
        $both = Arr::add($both, 'bts_atper', $bts_atper);
        $both = Arr::add($both, 'bts_home', $bts_home);
        $both = Arr::add($both, 'bts_away', $bts_away);
        $both = Arr::add($both, 'bts', $bts);

        //dd($both);
        return $both;
    }

    private function cardsTable($league,$home,$away)
    {
        /**
         * @var int 
         */
        // $total_matches = (int)Stat::where('stat_team','=',$teams)->count();
        // $yellow_card = (int)Stat::where('stat_team','=',$teams)->sum('stat_yellow_card');
        // $red_card = (int)Stat::where('stat_team','=',$teams)->sum('stat_red_card');

        /**
         * @var float
         */
        // $avercar_yell = round($yellow_card/$total_matches,2);
        // $avercar_red = round($red_card/$total_matches,2);

        $mt_home = totalMatches($league,$home);
        $mt_away = totalMatches($league,$away);
        
        $cards = collect([]);
        for($m=2; $m <= 8; $m++) {
            $car_home = cardsTeam($home,$m);
            $car_away = cardsTeam($away,$m);
            $per_card_home = round(($car_home*100)/$mt_home);
            $per_card_away = round(($car_away*100)/$mt_away);
            $avg_card = (($car_home+$car_away)*100)/($mt_home+$mt_away);

            $cards->push(['home'.$m => $per_card_home, 'away'.$m => $per_card_away, 'avg'.$m => $avg_card]);
        }


        return $cards;
    }

    private function cornersTable($league,$home,$away)
    {
        /**
         * @var int 
         */
        $matches = totalMatches($league,$home);

        $corners = collect([]);
        for($m=8; $m <= 14; $m++) {
            $cor_home = cornersTeam($home,$m);
            $cor_away = cornersTeam($away,$m);
            $per_corner_home = round(($cor_home*100)/$matches);
            $per_corner_away = round(($cor_away*100)/$matches);
            $avg_corner = (($cor_home+$cor_away)*100)/($matches*2);

            $corners->push(['home'.$m => $per_corner_home, 'away'.$m => $per_corner_away, 'avg'.$m => $avg_corner]);
        }
        
        // table('stats')->join('matches', 'matches.match_id','=','stats.stat_match')->where(function($t) use ($team){
        //     $t->where('matches.match_ht',$team)
        //         ->orWhere('matches.match_at',$team);
        // })->fromSub(function($c){
        //      $c->where('stat_match','matches.match_id')->sum('stat_corners');
        // }, 'co')->where('co','>',7.5)->count();
        return $corner;
    }

}
