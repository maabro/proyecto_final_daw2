@extends('layouts.main')

@section('title','Home')

@section('content')
    <h1>HOME VIEW</h1>
    @foreach($matches as $match)
    {{$match->match_id}}
    @endforeach
@endsection