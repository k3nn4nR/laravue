@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Person Edit</h1>
@stop

@section('content')
    <person-edit :id_number="{{ json_encode($id_number) }}"/>
@stop