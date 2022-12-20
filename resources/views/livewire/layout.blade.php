@extends('adminlte::page')

@section('title')
    {{config('app.name')}} - {{$title ?? 'Dashboard'}}
@endsection

@section('content_header')
    <h1>{{ $title ?? 'Dashboard' }}</h1>
@stop

@section('content')
    {{ $slot }}
@endsection


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
@stop
