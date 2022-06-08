@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Item Edit</h1>
@stop

@section('content')
    <item-edit :code="{{ json_encode($code) }}"/>
@stop