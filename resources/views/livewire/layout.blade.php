@extends('adminlte::page')

@section('title')
    {{--{{config('app.name')}} - --}}{{$title ?? 'Dashboard'}}
@endsection

@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><i class="{{$contentHeaderIcon??''}} mr-2"></i>{{$title??''}}</h1>
        </div>

        <div class="col-6">
            @isset($contentHeaderToolSlot)
                {{ $contentHeaderToolSlot }}
            @endisset
        </div>
    </div>
@stop

@section('content')
    {{ $slot }}
@endsection


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
