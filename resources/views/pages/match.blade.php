@extends('layouts.main')

@section('title',$mt->homeTeam->team_name.' vs '.$mt->awayTeam->team_name)

@section('content')
    <section class="match-content shadow-sm">
        <div class="match-header">
            <div class="row">
                <div class="col-sm">
                    <img src="/img/shields/{{$mt->homeTeam->team_img}}.png" alt="{{$mt->homeTeam->team_img}}" width="100">
                    <h2 class="mb-1"><a href="{{ route('pages.team', ['league_tag' => $mt->league->league_tag, 'team_tag' => $mt->homeTeam->team_tag]) }}">{{$mt->homeTeam->team_name}}</a></h2>               
                </div>
                <div class="col-sm">
                    <p class="mb-1">
                        <img src="/img/flags/{{$mt->league->league_country_flag}}.png" alt="{{$mt->league->league_country_flag}}" width="25">
                        {{$mt->league->league_country}}
                    </p>
                    <p class="mb-1">
                        <img src="/img/leagues/{{$mt->league->league_img}}.png" alt="{{$mt->league->league_img}}" width="25">
                        {{$mt->league->league_name}}
                    </p>
                    <p class="mb-1">{{\Carbon\Carbon::parse($mt->match_day)->format('d/m/Y')}}</p>
                    <p class="mb-1">{{\Carbon\Carbon::parse($mt->match_hour)->format('H:i')}}</p>
                </div>
                <div class="col-sm">
                    <img src="/img/shields/{{$mt->awayTeam->team_img}}.png" alt="{{$mt->homeTeam->team_img}}" width="100">
                    <h2 class="mb-1"><a href="{{ route('pages.team', ['league_tag' => $mt->league->league_tag, 'team_tag' => $mt->awayTeam->team_tag]) }}">{{$mt->awayTeam->team_name}}</a></h2>
                </div>              
            </div>         
        </div>
        <hr>
        <h4>Stats both teams</h4>
        <div class="row">
            <div class="col">
                <p>AVG Goals</p>
                <p>{{$mt->avg}}</p>
            </div>
            <div class="col">
                <p>BTS</p>
                <p>{{$mt->bts['bts_per']}}%</p>
            </div>
            <div class="col">
                <p>Over 1.5</p>
                <p>{{$mt->overs[0]['name2']}}%</p>
            </div>
            <div class="col">
                <p>Over 2.5</p>
                <p>{{$mt->overs[1]['name3']}}%</p>
            </div>
        </div>
        <p>Calculated from {{$mt->homeTeam->team_name}} Home stats and {{$mt->awayTeam->team_name}} Away stats</p>
        <div class="goal-market">
            <div class="row">
                <div class="col">
                    <h4>Over goals match</h4>
                    <div class="goal-table p-2">
                        <table class="table table-sm table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th class="text-center">{{$mt->homeTeam->team_name}}</th>
                                    <th class="text-center">{{$mt->awayTeam->team_name}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($mt->goals as $goal)
                                <tr>
                                    <td>{{$goal['name']}}</td>
                                    <td class="text-center">{{$goal['home']}}%</td>
                                    <td class="text-center">{{$goal['away']}}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>                
                </div>
                <div class="col">
                    <h4>Both teams to score</h4>
                    <div class="bts-table p-2">
                        <table class="table table-sm table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th class="text-center">{{$mt->homeTeam->team_name}}</th>
                                    <th class="text-center">{{$mt->awayTeam->team_name}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Yes</td>
                                    <td class="text-center">{{$mt->bts['home_yes']}}%</td>
                                    <td class="text-center">{{$mt->bts['away_yes']}}%</td>
                                </tr>
                                <tr>
                                    <td>No</td>
                                    <td class="text-center">{{$mt->bts['home_no']}}%</td>
                                    <td class="text-center">{{$mt->bts['away_no']}}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>               
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <div class="corner-market p-2">
                    <h4>Over corners during the match</h4>
                    <div class="corner-table">
                        <table class="table table-sm table-striped">
                            <thead  class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th class="text-center">{{$mt->homeTeam->team_name}}</th>
                                    <th class="text-center">{{$mt->awayTeam->team_name}}</th>
                                    <th class="text-center">Average</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($mt->corners as $corner)
                                <tr>
                                    <td>{{$corner['name']}}</td>
                                    <td class="text-center">{{$corner['home']}}%</td>
                                    <td class="text-center">{{$corner['away']}}%</td>
                                    <td class="text-center">{{$corner['avg']}}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="corner-market p-2">
                    <h4>Over cards during the match</h4>
                    <div class="card-table">
                        <table class="table table-sm table-striped">
                            <thead  class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th class="text-center">{{$mt->homeTeam->team_name}}</th>
                                    <th class="text-center">{{$mt->awayTeam->team_name}}</th>
                                    <th class="text-center">Average</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($mt->cards as $card)
                                <tr>
                                    <td>{{$card['name']}}</td>
                                    <td class="text-center">{{$card['home']}}%</td>
                                    <td class="text-center">{{$card['away']}}%</td>
                                    <td class="text-center">{{$card['avg']}}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection