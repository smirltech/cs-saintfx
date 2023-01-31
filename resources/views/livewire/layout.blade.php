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

@section('footer')
    <strong>Copyright © 2019-{{ date('Y') }} <a href="https://smirltech.com">Smirltech.com</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> {{App\Helpers\Helpers::$appVersion}}
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
