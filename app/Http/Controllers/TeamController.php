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
             
        return view('pages.team', compact('lg'));
    }
}
