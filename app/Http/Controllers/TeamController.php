<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $lg = DB::table('teams')->where('team_tag','=',$team)->first();  
        //$teams = League::find($lg->league_id)->teams;     
        //$sc = $this->teamsResults($lg->league_id,$team->team_id);   
             
        return view('pages.team', compact('lg'));
    }


    private function teamResults($league,$team)
    {
        $matches = totalMatches($league,$team);
        $matches_local = League::find($league)->matches->where('match_ht','=',$team)->count();
        $matches_away = League::find($league)->matches->where('match_at','=',$team)->count();
        $win_local = League::find($league)->matches->where('match_ht','=',$team)->where('match_final_res','=','H')->count();
        $win_away = League::find($league)->matches->where('match_at','=',$team)->where('match_final_res','=','A')->count();
        $draw_match = DB::table('matches')->where('match_league',$league)->where(function($query) use ($team){
            $query->where('match_ht','=',$team)
                ->orWhere('match_at','=',$team);
        })->where('match_final_res','=','D')->count();

        $per_homewins = round(($win_local*100)/$matches_local);
        $per_awaywins = round(($win_away*100)/$matches_away);
        $per_draws = round(($draw_match*100)/$matches);

        return ['home' => $per_homewins,'away' => $per_awaywins,'draw' => $per_draws];
    }
}
