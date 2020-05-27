@extends('layouts.main')

@section('title','Leagues')

@section('content')
    <section class="leagues-content shadow-sm">
        <h4 class="px-3 pt-4">World Football Leagues</h4>
        <div class="table-responsive p-3">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>League</th>
                        <th class="text-center">Home wins %</th>
                        <th class="text-center">Draw %</th>
                        <th class="text-center">Away wins %</th>
                        <th class="text-center">BTS %</th>
                        <th class="text-center">+0,5 %</th>
                        <th class="text-center">+1,5 %</th>
                        <th class="text-center">+2,5 %</th>                               
                    </tr>
                </thead>
                <tbody>
                @foreach($leagues as $lg)
                    <tr>
                        <td class="border-right">
                            <img class="league-flag" src="/img/flags/{{$lg->league_country_flag}}.png" alt="{{$lg->league_country_flag}}" width="20">
                            <a href="{{ route('pages.league', ['league_tag' => $lg->league_tag]) }}">{{$lg->league_name}}</a>
                        </td>
                        @for($n = 0;$n < $results->count();$n++)
                        @if($lg->league_id == $results[$n]['id'])
                        <td class="text-center border-right">{{$results[$n]['res']['home']}}%</td>
                        <td class="text-center border-right">{{$results[$n]['res']['draw']}}%</td>
                        <td class="text-center border-right">{{$results[$n]['res']['away']}}%</td>
                        <td class="text-center border-right">{{$results[$n]['bts']}}%</td>
                        <td class="text-center border-right">{{$results[$n]['o0.5']}}%</td>
                        <td class="text-center border-right">{{$results[$n]['o1.5']}}%</td>
                        <td class="text-center">{{$results[$n]['o2.5']}}%</td>
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
    </section>
@endsection