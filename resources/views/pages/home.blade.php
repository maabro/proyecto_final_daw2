@extends('layouts.main')

@section('title','Home')

@section('content')
    <h1>HOME VIEW</h1>
    @foreach($matches as $match)
    <p>{{$match->homeTeam->team_name}}
    <a href="{{ route('pages.match', ['match' => $match->match_id, 'ht_tag' => $match->homeTeam->team_tag, 'at_tag' => $match->awayTeam->team_tag]) }}">
        <i class="far fa-chart-bar"></i>
    </a>
    {{$match->awayTeam->team_name}}</p>
    @endforeach
@endsection