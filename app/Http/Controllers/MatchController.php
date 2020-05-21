<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
