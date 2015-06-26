@extends('index')
@section('content')
    <img id="pic" src="{{URL::to('/') . '/' . $path}}"/>
@stop