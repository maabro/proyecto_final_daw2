<?php

function totalMatches($league,$team)
{
    return DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
        $m->where('match_ht',$team)
            ->orWhere('match_at',$team);
    })->count();
}

function teamsResultsMatch($league,$team)
{
    $matches = totalMatches($league,$team);
    $wins = DB::table('matches')->where('match_league',$league)->where(function($w) use ($team){
        $w->where('match_ht',$team)
            ->where('match_final_res','H');
    })->orWhere(function($w2) use ($team){
        $w2->where('match_at',$team)
            ->where('match_final_res','A');
    })->count();

    $loses = DB::table('matches')->where('match_league',$league)->where(function($w) use ($team){
        $w->where('match_ht',$team)
            ->where('match_final_res','A');
    })->orWhere(function($w2) use ($team){
        $w2->where('match_at',$team)
            ->where('match_final_res','H');
    })->count();

    $draws = DB::table('matches')->where('match_league',$league)->where(function($l) use ($team){
        $l->where('match_ht',$team)
            ->orWhere('match_at',$team);
    })->where('match_final_res','D')->count();

    return ['total' => $matches, 'wins' => $wins, 'draws' => $draws, 'loses' => $loses];
}