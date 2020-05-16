@extends('layouts.main')

@section('title',$lg->league_name)

@section('content')

    <h1>{{$lg->league_name}}</h1>
    <p>{{$lg->league_tag}}</p>
@endsection