@extends('layouts.main')

@section('title',$mt->homeTeam->team_name.' vs '.$mt->awayTeam->team_name)

@section('content')
    <section class="match-content shadow-sm">
        <div class="match-header">
            <div class="row">
                <div class="col-sm">
                    <img src="/img/shields/{{$mt->homeTeam->team_img}}.png" alt="{{$mt->homeTeam->team_img}}" width="100">
                    <p class="mb-1"><a href="{{ route('pages.team', ['league_tag' => $mt->league->league_tag, 'team_tag' => $mt->homeTeam->team_tag]) }}">{{$mt->homeTeam->team_name}}</a></p>               
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
                    <p class="mb-1"><a href="{{ route('pages.team', ['league_tag' => $mt->league->league_tag, 'team_tag' => $mt->awayTeam->team_tag]) }}">{{$mt->awayTeam->team_name}}</a></p>
                </div>              
            </div>         
        </div>
        <hr>
        <div class="goal-market">
            <h4>Over goals match</h4>
            <div class="goal-table">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>{{$mt->homeTeam->team_name}}</th>
                            <th>{{$mt->awayTeam->team_name}}</th>
                            <th>Both teams</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Over 0.5</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Over 1.5</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Over 2.5</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Over 3.5</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Both teams to score</h4>
                    <div class="bts-table">
                        <table class="table table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th>{{$mt->homeTeam->team_name}}</th>
                                    <th>{{$mt->awayTeam->team_name}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Yes</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>No</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>               
                </div>
                <div class="col">
                <h4>Clean sheet</h4>
                <div class="cs-table">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>{{$mt->homeTeam->team_name}}</th>
                                <th>{{$mt->awayTeam->team_name}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Yes</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>-</td>
                                <td>-</td>
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
                <div class="corner-market">
                    <h4>Over corners during the match</h4>
                    <div class="corner-table">
                        <table class="table table-sm">
                            <thead  class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th>{{$mt->homeTeam->team_name}}</th>
                                    <th>{{$mt->awayTeam->team_name}}</th>
                                    <th>Average</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Over 7.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 8.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 9.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 10.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 11.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 12.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 13.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="corner-market">
                    <h4>Over cards during the match</h4>
                    <div class="card-table">
                        <table class="table table-sm">
                            <thead  class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th>{{$mt->homeTeam->team_name}}</th>
                                    <th>{{$mt->awayTeam->team_name}}</th>
                                    <th>Average</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Over 1.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 2.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 3.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 4.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 5.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 6.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Over 7.5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection