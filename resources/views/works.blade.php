@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Work List</h1>
@stop

@section('content')
    <work-list  :user="{{ json_encode(Auth::user()) }}"/>
@stop