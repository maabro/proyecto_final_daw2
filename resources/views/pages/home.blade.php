@extends('layouts.main')

@section('title','Home')

@section('content')
    <h1>HOME VIEW</h1>
    @foreach($matches as $match)
    {{$match->homeTeam->team_name}}
    <a href="{{ route('pages.match', ['ht_tag' => $match->homeTeam->team_tag, 'at_tag' => $match->awayTeam->team_tag]) }}">{{$match->match_id}}</a>
    {{$match->awayTeam->team_name}}<br>
    @endforeach
@endsection