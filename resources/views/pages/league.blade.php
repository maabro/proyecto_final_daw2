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
                        <th>Position</th>
                        <th>Name</th>
                        <th>PTS</h>
                        <th>HW</th>
                        <th>D</th>
                        <th>AW</th>
                        <th>BTS</th>
                        <th>O0.5</th>
                        <th>O1.5</th>
                        <th>O2.5</th>
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
                        @for($n = 0; $n < $points->count(); $n++)
                        @if($team->team_id == $points[$n]['team_id'])
                        <td>{{$points[$n]['point']}}</td>
                        @endif
                        @endfor
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection