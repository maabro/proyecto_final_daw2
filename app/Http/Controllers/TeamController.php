<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class TeamController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  String  $league
     * @return \Illuminate\Http\Response
     */
    public function show($league,$team)
    {
        //dd($league);
        $team = Team::where('team_tag','=',$team)->first();
        //$league =  Team::where('team_tag','=',$team)->leagues;
        //dd($team->league);
        //$teams = League::find($lg->league_id)->teams;     
        //$sc = $this->teamsResults($lg->league_id,$team->team_id);
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

        //dd($this->teamGoalsHt('T225',1));
             
        return view('pages.team', compact('team'));
    }


    private function teamResHomeFt($team)
    {
        $wins = DB::table('matches')->where('match_ht',$team)->where('match_final_res','H')->count();
        $draws = DB::table('matches')->where('match_ht',$team)->where('match_final_res','D')->count();
        $loses = DB::table('matches')->where('match_ht',$team)->where('match_final_res','A')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }

    private function teamResAwayFt($team)
    {
        $wins = DB::table('matches')->where('match_at',$team)->where('match_final_res','A')->count();
        $draws = DB::table('matches')->where('match_at',$team)->where('match_final_res','D')->count();
        $loses = DB::table('matches')->where('match_at',$team)->where('match_final_res','H')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }

    private function teamResHomeHt($team)
    {
        $wins = DB::table('matches')->where('match_ht',$team)->where('match_ht_res','H')->count();
        $draws = DB::table('matches')->where('match_ht',$team)->where('match_ht_res','D')->count();
        $loses = DB::table('matches')->where('match_ht',$team)->where('match_ht_res','A')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }

    private function teamResAwayHt($team)
    {
        $wins = DB::table('matches')->where('match_at',$team)->where('match_ht_res','A')->count();
        $draws = DB::table('matches')->where('match_at',$team)->where('match_ht_res','D')->count();
        $loses = DB::table('matches')->where('match_at',$team)->where('match_ht_res','H')->count();
        return ['wins'=>$wins,'draws'=>$draws,'loses'=>$loses];
    }

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

    private function teamGoalsFt($league,$team,$n)
    {
        $ht = DB::table('matches')->where(function($t) use ($team){
            $t->where('match_ht',$team)
            ->orWhere('match_at',$team);
        })->whereRaw("(match_goals_home+match_goals_away) >= ".$n)->count();

        return ['ht' => round(($ht*100)/totalMatches($league,$team))];
    }

    private function teamGoalAvgHt($league,$team)
    {

    }

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
}
