@extends('layouts.main')

@section('title','Leagues')

@section('content')
    <div class="table-responsive shadow-sm">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>League</th>
                    <th>HW</th>
                    <th>AW</th>
                    <th>O.0,5</th>
                    <th>O.1,5</th>
                    <th>O.2,5</th>
                    <th>BTS</th>            
                </tr>
            </thead>
            <tbody>
            @foreach($leagues as $lg)
                <tr>
                    <td>
                        <img class="league-flag" src="/img/flags/{{$lg->league_country_flag}}.png" alt="{{$lg->league_country_flag}}" width="20">
                        <a href="{{ route('pages.league', ['league_tag' => $lg->league_tag]) }}">{{$lg->league_name}}</a>
                    </td>
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
    <div class="help-content">
        <span class="p-1">HW: Home team win</span>
        <span class="p-1">AW: Away team win</span>
        <span class="p-1">BTS: Both teams to score</span>
        <span class="p-1">O.0,5: Over 0,5 goals</span>
        <span class="p-1">O.1,5: Over 1,5 goals</span>
        <span class="p-1">O.2,5: Over 2,5 goals</span>
    </div>
@endsection