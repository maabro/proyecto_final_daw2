@extends('layouts.main')

@section('title','Home')

@section('content')
    <h1>HOME VIEW</h1>
    
    @foreach($league as $l)
    <p><img src="/img/flags/{{$l['flag']}}.png" alt="" width="25"> {{$l['country']}} . {{$l['name']}}</p>
    @foreach($l['matches'] as $mt)
    <p>{{$mt->match_day}}</p>
    <p>{{$mt->match_hour}} {{$mt->homeTeam->team_name}}
    <a href="{{ route('pages.match', ['match' => $mt->match_id, 'ht_tag' => $mt->homeTeam->team_tag, 'at_tag' => $mt->awayTeam->team_tag]) }}">
        <i class="far fa-chart-bar"></i>
    </a>
    {{$mt->awayTeam->team_name}}</p>
    @endforeach
    @endforeach
@endsection