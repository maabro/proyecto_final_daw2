@extends('layouts.main')

@section('title','Leagues')

@section('content')
    <div class="table-responsive shadow-sm">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>League</th>
                    <th>HW</th>
                    <th>D</th>
                    <th>AW</th>
                    <th>BTS</th>
                    <th>O.0,5</th>
                    <th>O.1,5</th>
                    <th>O.2,5</th>                               
                </tr>
            </thead>
            <tbody>
            @foreach($leagues as $lg)
                <tr>
                    <td>
                        <img class="league-flag" src="/img/flags/{{$lg->league_country_flag}}.png" alt="{{$lg->league_country_flag}}" width="20">
                        <a href="{{ route('pages.league', ['league_tag' => $lg->league_tag]) }}">{{$lg->league_name}}</a>
                    </td>
                    @for($n = 0;$n < $results->count();$n++)
                    @if($lg->league_id == $results[$n]['id'])
                    <td>{{$results[$n]['res']['home']}}%</td>
                    <td>{{$results[$n]['res']['draw']}}%</td>
                    <td>{{$results[$n]['res']['away']}}%</td>
                    <td>{{$results[$n]['bts']}}%</td>
                    <td>{{$results[$n]['o0.5']}}%</td>
                    <td>{{$results[$n]['o1.5']}}%</td>
                    <td>{{$results[$n]['o2.5']}}%</td>
                    @endif
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="help-content">
        <span class="p-1">HW: Home team win</span>
        <span class="p-1">AW: Away team win</span>
        <span class="p-1">BTS: Both teams to score</span>
        <span class="p-1">O.0,5: Over 0,5 goals</span>
        <span class="p-1">O.1,5: Over 1,5 goals</span>
        <span class="p-1">O.2,5: Over 2,5 goals</span>
    </div>
@endsection