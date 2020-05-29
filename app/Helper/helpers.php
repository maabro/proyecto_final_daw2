<?php
/**
 * Calcula el numero total de partidos de un equipo
 * 
 * @param String $league variable con el id de la liga
 * @param String $team variable con el id del equipo
 * @return Integer devuelve el numero de partidos
 */
function totalMatches($league,$team)
{
    return DB::table('matches')->where('match_league',$league)->where(function($m) use ($team){
        $m->where('match_ht',$team)
            ->orWhere('match_at',$team);
    })->count();
}
/**
 * Calcula el numero de partidos que ha ganado, empatado y perdido un equipo
 * 
 * @param String $league variable con el id de la liga
 * @param String $team variable con el id del equipo
 * @return Array devuelve el numero total, las victorias, derrotas y empates de un equipo
 */
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
/**
 * Calcula el numero partidos donde se superan X numero de corners
 * 
 * @param String $team variable con el id de la liga
 * @param Integer $n variable contadora
 * @return Integer devuelve el numero de partidos
 */
function cornersTeam($team,$n)
{
    $db = DB::selectOne("select count(*) as co from (select distinct matches.* from stats inner join matches on matches.match_id = stats.stat_match 
    where (matches.match_ht = ? or matches.match_at = ?) and (select sum(stat_corners) from stats 
    where stat_match = matches.match_id) >= ?) as loquesea",[$team,$team,$n]);   
    return $db->co;
}
/**
 * Calcula el numero partidos donde se superan X numero de tarjetas
 * 
 * @param String $team variable con el id de la liga
 * @param Integer $n variable contadora
 * @return Integer devuelve el numero de partidos
 */
function cardsTeam($team,$n)
{
    $y = DB::selectOne("select count(*) as co from (select distinct matches.* from stats inner join matches on matches.match_id = stats.stat_match 
    where (matches.match_ht = ? or matches.match_at = ?) and (select sum(stat_yellow_card)+sum(stat_red_card) from stats 
    where stat_match = matches.match_id) >= ?) as loquesea",[$team,$team,$n]);
    return $y->co;
}