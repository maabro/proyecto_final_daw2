<?php

namespace App\Http\Controllers;

use App\Match;
use App\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $matches = Match::whereBetween('match_day', ['2020-06-03', '2020-06-07'])->get();
 
        return view('pages.home',compact('matches'));
    }

    public function show($match)
    {
        //dd($match);
        $mt = Match::find($match);  
        //$mt->awayTeam->team_id,$mt->homeTeam->team_id
        $ht = $mt->homeTeam->team_id;
        $goals = $this->goalsTable($ht);
        $cards = $this->cardsTable($ht);
        $bts = $this->bothTeamscore($mt->homeTeam->team_id, $mt->awayTeam->team_id);
        //var_dump($cards);
        dd($bts);   
        return view('pages.match', compact('mt'));
    }

    private function goalsTable($team)
    {   
        /**
         * @var int
         */
        $h = 0;
        $a = 0;
        $home_goals = Match::where('match_ht','=',$team)
                        ->where('match_final_res','!=','')->get();
        
        foreach($home_goals as $hg){
            $h += $hg->match_goals_home;
        }

        $away_goals = Match::where('match_at','=',$team)
                        ->where('match_final_res','!=','')->get();
        
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

        dd($both);
        return $both;
    }

    private function cardsTable($teams)
    {
        /**
         * @var int 
         */
        $total_matches = (int)Stat::where('stat_team','=',$teams)->count();
        $yellow_card = (int)Stat::where('stat_team','=',$teams)->sum('stat_yellow_card');
        $red_card = (int)Stat::where('stat_team','=',$teams)->sum('stat_red_card');

        /**
         * @var float
         */
        $avercar_yell = round($yellow_card/$total_matches,2);
        $avercar_red = round($red_card/$total_matches,2);

        
        $cards = Arr::add([], 'yellow_car', $yellow_card);
        $cards = Arr::add($cards, 'red_card', $red_card);
        $cards = Arr::add($cards, 'total_matches', $total_matches);
        $cards = Arr::add($cards, 'avercar_yell', $avercar_yell);
        $cards = Arr::add($cards, 'avercar_red', $avercar_red);

        return $cards;
    }

    private function cornersTable($teams)
    {
        /**
         * @var int 
         */
        $total_matches = (int)Stat::where('stat_team','=',$teams)->count();
        $yellow_card = (int)Stat::where('stat_team','=',$teams)->sum('stat_yellow_card');

        /**
         * @var float
         */
        $avercar_yell = round($yellow_card/$total_matches,2);

        
        $cards = Arr::add([], 'yellow_car', $yellow_card);
        $cards = Arr::add($cards, 'total_matches', $total_matches);
        $cards = Arr::add($cards, 'avercar_yell', $avercar_yell);

        return $cards;
    }



}
