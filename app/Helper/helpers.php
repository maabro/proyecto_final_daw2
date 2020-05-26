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

function cornersTeam($team,$n)
{
    $db = DB::selectOne("select count(*) as co from (select distinct matches.* from stats inner join matches on matches.match_id = stats.stat_match 
    where (matches.match_ht = ? or matches.match_at = ?) and (select sum(stat_corners) from stats 
    where stat_match = matches.match_id) >= ?) as loquesea",[$team,$team,$n]);   
    return $db->co;
}

function cardsTeam($team,$n)
{
    $y = DB::selectOne("select count(*) as co from (select distinct matches.* from stats inner join matches on matches.match_id = stats.stat_match 
    where (matches.match_ht = ? or matches.match_at = ?) and (select sum(stat_yellow_card)+sum(stat_red_card) from stats 
    where stat_match = matches.match_id) >= ?) as loquesea",[$team,$team,$n]);
    return $y->co;
}