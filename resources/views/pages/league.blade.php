@extends('layouts.main')

@section('title',$lg->league_name)

@section('content')
    <section class="league-content shadow-sm">
        <div class="league-header">
            <img src="/img/leagues/{{$lg->league_img}}.png" alt="{{$lg->league_img}}" width="90">
            <h1>{{$lg->league_name}}</h1>
            <p>{{$lg->league_country}}</p>        
        </div>
        <hr>
        <div class="classification p-2">
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Clas.</th>
                        <th>Name</th>
                        <th>MP</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GF</th>
                        <th>GA</th>
                        <th>GD</th>
                        <th>PTS</th>
                        <th>CS</th>
                        <th>FTS</th>
                        <th>YC</th>
                        <th>RC</th>
                        <th>Corner</th>
                        <th>BTS</th>
                        <th>AVG</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr>
                        <td>{{$count++}}</td>
                        <td>
                            <img src="/img/shields/{{$team->team_img}}.png" alt="{{$team->team_img}}" width="20">
                            <a href="{{ route('pages.team', ['league_tag' => $lg->league_tag, 'team_tag' => $team->team_tag]) }}">{{$team->team_name}}</a>
                        </td>
                        <td>{{$team->matches['total']}}</td>
                        <td>{{$team->matches['wins']}}</td>
                        <td>{{$team->matches['draws']}}</td>
                        <td>{{$team->matches['loses']}}</td>
                        <td>{{$team->goals_gf}}</td>
                        <td>{{$team->goals_ga}}</td>
                        <td>{{($team->goals_gf-$team->goals_ga > 0) ? "+".(string)($team->goals_gf-$team->goals_ga) : $team->goals_gf-$team->goals_ga}}</td>
                        <td>{{$team->point}}</td>
                        <td>{{$team->clean_sheets}}%</td>
                        <td>{{$team->fts}}%</td>
                        <td>{{$team->cards['yellow']}}</td>
                        <td>{{$team->cards['red']}}</td>
                        <td>{{$team->corners}}</td>
                        <td>{{$team->bts}}%</td>
                        <td>{{$team->avg}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection