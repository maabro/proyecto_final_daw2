@extends('layouts.main')

@section('title','Home')

@section('content')
    <section class="league-content shadow-sm">
        <div class="row">
            <div class="col-xl-12">
                <div class="home-header p-2">
                    <h1 class="d-inline-block">Soccermarkt</h1><span class="d-inline-block px-2"> - </span><h2 class="d-inline-block">Football stats for football users</h2>
                    <p>We provide statistics on goals, corners and cards of the most important soccer leagues.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
            @foreach($league as $l)
                <p class="mx-2 league-text pb-1"><b><img src="/img/flags/{{$l['flag']}}.png" alt="" width="25"> {{$l['country']}} · {{$l['name']}}</b></p>            
                <div class="matches-table table-responsive py-3 px-4">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Match day</th>
                                <th class="text-center">Match hour</th>
                                <th class="text-right">Home team</th>
                                <th></th>
                                <th>Away team</th>
                            </tr>
                        </thead>
                        <tbody>
                @foreach($l['matches'] as $mt)
                            <tr>
                                <td width="10%" class="text-center">{{\Carbon\Carbon::parse($mt->match_day)->format('d/m/Y')}}</td>
                                <td width="10%"  class="text-center">{{\Carbon\Carbon::parse($mt->match_hour)->format('H:i')}}</td>
                                <td width="40%" class="text-right">{{$mt->homeTeam->team_name}}</td>
                                <td width="5%" class="text-center">
                                    <a href="{{ route('pages.match', ['match' => $mt->match_id, 'ht_tag' => $mt->homeTeam->team_tag, 'at_tag' => $mt->awayTeam->team_tag]) }}">
                                        <i class="far fa-chart-bar"></i>
                                    </a>
                                </td>
                                <td width="40%">{{$mt->awayTeam->team_name}}</td>
                            </tr>
                @endforeach
                        </tbody>
                    </table>                    
                </div>
            @endforeach
            </div>
        </div>
    </section>
@endsection