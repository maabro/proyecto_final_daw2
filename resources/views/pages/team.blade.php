@extends('layouts.main')

@section('title',$lg->team_name)

@section('content')
<img src="/img/shields/{{$lg->team_img}}.png" alt="{{$lg->team_img}}" width="90">
@endsection