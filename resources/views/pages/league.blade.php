@extends('layouts.main')

@section('title',$lg->league_name)

@section('content')
    <section class="league-content shadow-sm">
        <div class="row">
            <div class="col">
                <div class="league-header">
                    <img class="league-img" src="/img/leagues/{{$lg->league_img}}.png" alt="{{$lg->league_img}}" width="90">
                    <h1 class="league-name">{{$lg->league_name}}</h1>
                    <span class="league-country"><img src="/img/flags/{{$lg->league_country_flag}}.png" alt="" width="25"> {{$lg->league_country}}</span>     
                </div>            
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h4 class="pl-3 pt-3">{{$lg->league_name}} table</h4>
                <div class="classification table-responsive p-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Clas.</th>
                                <th>Team</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Matches played this season">MP</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Win">W</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Draw">D</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Loss">L</th>
                                <th class="text-center" data-toggle="tooltip" data-html="true" data-placement="top" title="<b>Goals for</b><p>The number of goals have team score</p>">GF</th>
                                <th class="text-center" data-html="true" data-toggle="tooltip" data-placement="top" title="<b>Goals Against</b><p>The number of goals have team conceded</p>">GA</th>
                                <th class="text-center" data-html="true" data-toggle="tooltip" data-placement="top" title="<b>Goals Difference</b><p>Goals score- Goals conceded</p>">GD</th>
                                <th class="text-center">Pts</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Clean sheets">CS</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Failed to score">FTS</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Yellow cards /match">YC</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Red cards /match">RC</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Corners /match">Corner</th>
                                <th class="text-center" data-toggle="tooltip" data-placement="top" title="Both teams to score">BTS</th>
                                <th class="text-center" data-html="true" data-toggle="tooltip" data-placement="top" title="<b>Average goals per match</b><p>The average number of total goals per match.</p>">AVG</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{$count++}}</td>
                                <td class="border-right">
                                    <img src="/img/shields/{{$team->team_img}}.png" alt="{{$team->team_img}}" width="20">
                                    <a href="{{ route('pages.team', ['league_tag' => $lg->league_tag, 'team_tag' => $team->team_tag]) }}">{{$team->team_name}}</a>
                                </td>
                                <td class="text-center border-right">{{$team->matches['total']}}</td>
                                <td class="text-center border-right">{{$team->matches['wins']}}</td>
                                <td class="text-center border-right">{{$team->matches['draws']}}</td>
                                <td class="text-center border-right">{{$team->matches['loses']}}</td>
                                <td class="text-center border-right text-success">{{$team->goals_gf}}</td>
                                <td class="text-center border-right text-danger">{{$team->goals_ga}}</td>
                                <td class="text-center border-right">{{($team->goals_gf-$team->goals_ga > 0) ? "+".(string)($team->goals_gf-$team->goals_ga) : $team->goals_gf-$team->goals_ga}}</td>
                                <td class="text-center border-right">{{$team->point}}</td>
                                <td class="text-center border-right">{{$team->clean_sheets}}%</td>
                                <td class="text-center border-right">{{$team->fts}}%</td>
                                <td class="text-center border-right">{{$team->cards['yellow']}}</td>
                                <td class="text-center border-right">{{$team->cards['red']}}</td>
                                <td class="text-center border-right">{{$team->corners}}</td>
                                <td class="text-center border-right">{{$team->bts}}%</td>
                                <td class="text-center">{{$team->avg}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>            
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="term-content mx-3 mb-3 bg-info">
                    <h6 class="pl-2 pt-2"><b>Terminologies</b></h6>
                    <p class="pl-2"><b>CS</b> : Table of teams with the highest number of matches where they conceded 0 goals. Stats are taken from League runs only.</p>
                    <p class="pl-2"><b>BTTS</b> : List of teams with the highest number of matches where both teams scored. Stats from team's Domestic League runs only.</p>
                    <p class="pl-2 pb-2"><b>FTS</b> : Matches where this team failed to score.</p>                
                </div>
            </div>        
        </div>       
    </section>
@endsection