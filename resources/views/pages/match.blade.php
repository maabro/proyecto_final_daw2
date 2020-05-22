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
            <h3>Goals market</h3>
        </div>
        <hr>
        <div class="coner-market">
            <h3>Corners market</h3>
        </div>
        <hr>
        <div class="card-market">
            <h3>Cards market</h3>
        </div>
    </section>
@endsection