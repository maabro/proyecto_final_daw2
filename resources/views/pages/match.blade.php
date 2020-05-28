@extends('layouts.main')

@section('title',$mt->homeTeam->team_name.' vs '.$mt->awayTeam->team_name)

@section('content')
    <section class="match-content shadow-sm">
        <div class="match-header">
            <div class="row">
                <div class="col-xl-4 col-sm-4 mt-3">
                    <img src="/img/shields/{{$mt->homeTeam->team_img}}.png" alt="{{$mt->homeTeam->team_img}}" width="20%">
                    <h2 class="mb-1"><a href="{{ route('pages.team', ['league_tag' => $mt->league->league_tag, 'team_tag' => $mt->homeTeam->team_tag]) }}">{{$mt->homeTeam->team_name}}</a></h2>               
                    <p>Home Team</p>
                </div>
                <div class="col-xl-4 col-sm-4 mt-3 py-3">
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
                <div class="col-xl-4 col-sm-4 mt-3">
                    <img src="/img/shields/{{$mt->awayTeam->team_img}}.png" alt="{{$mt->homeTeam->team_img}}" width="20%">
                    <h2 class="mb-1"><a href="{{ route('pages.team', ['league_tag' => $mt->league->league_tag, 'team_tag' => $mt->awayTeam->team_tag]) }}">{{$mt->awayTeam->team_name}}</a></h2>
                    <p>Away Team</p>
                </div>              
            </div>         
        </div>
        <h3 class="mx-2 mt-4 title-stat">Stats both teams</h3>
        <div class="row text-center">
            <div class="col-xl-3 col-sm-2">
                <div class="avg-tables">
                    <p>AVG Goals</p>
                    <p>{{$mt->avg}}</p>
                </div>
            </div>
            <div class="col-xl-3 col-sm-2">
                <div class="avg-tables">
                    <p>BTS</p>
                    <p>{{$mt->bts['bts_per']}}%</p>
                </div>
            </div>
            <div class="col-xl-3 col-sm-2">
                <div class="avg-tables">
                    <p>Over 1.5</p>
                    <p>{{$mt->overs[0]['name2']}}%</p>
                </div>
            </div>
            <div class="col-xl-3 col-sm-2">
                <div class="avg-tables">
                    <p>Over 2.5</p>
                    <p>{{$mt->overs[1]['name3']}}%</p>
                </div>
            </div>
        </div>
        <p class="text-center mb-4">Calculated from {{$mt->homeTeam->team_name}} Home stats and {{$mt->awayTeam->team_name}} Away stats</p>
        <div class="goal-market">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mx-2 title-stat">Over goals match</h3>
                    <div class="goal-table px-2 pb-2 pt-3">
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
                        <p>First column is over goals are calculated from total goals in a match that {{$mt->homeTeam->team_name}} has participated.</p>
                        <p>Second column is over goals are calculated from total goals in a match that {{$mt->awayTeam->team_name}} has participated.</p>
                    </div>             
                </div>
                <div class="col-sm-6">
                    <h3 class="mx-2 title-stat">Both teams to score</h3>
                    <div class="bts-table px-2 pb-2 pt-3">
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
                        <p>First column is average in % for macthes involving {{$mt->homeTeam->team_name}} where both teams score.</p>
                        <p>Second column is average in % for macthes involving {{$mt->awayTeam->team_name}} where both teams score.</p>
                    </div>               
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="corner-market p-2">
                    <h3 class="title-stat">Over corners during the match</h3>
                    <div class="corner-table pt-3">
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
                    <p>First column is average total corners per match in % for matches involving {{$mt->homeTeam->team_name}}.</p>
                    <p>Second column is average total corners per match in % for matches involving {{$mt->awayTeam->team_name}}.</p>
                    <p>Last column is an average percentage for total corners over, calculated between {{$mt->homeTeam->team_name}} and {{$mt->awayTeam->team_name}} for 2.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="corner-market p-2">
                    <h3 class="title-stat">Over cards during the match</h3>
                    <div class="card-table pt-3">
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
                    <p>First column is average total cards per match in % for matches involving {{$mt->homeTeam->team_name}}.</p>
                    <p>Second column is average total cards per match in % for matches involving {{$mt->awayTeam->team_name}}.</p>
                    <p>Last column is an average percentage for total cards over, calculated between {{$mt->homeTeam->team_name}} and {{$mt->awayTeam->team_name}} for 2.</p>
                </div>
            </div>
        </div>
    </section>
@endsection