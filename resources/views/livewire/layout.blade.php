@extends('adminlte::page')

@section('title')
    {{$title ?? null}}
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
    <strong>Copyright© {{ date('Y') }} CENK</strong>
    {{__('All rights reserved.')}}
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> {{App\Helpers\Helpers::$appVersion}} | {{date('d.m.Y H:i')}}
    </div>
@stop
