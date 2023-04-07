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
    <strong>Copyright© {{ date('Y') }} {{config('app.name')}}</strong>
    {{__('All rights reserved.')}}
    <div class="float-right d-none d-sm-inline-block">
        {{date('d.m.Y H:i')}}
    </div>
@stop
@push('css')
    {{-- @vite(['resources/sass/admin.scss', 'resources/js/admin.js'])--}}
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <style>
        .sidebar-dark-primary {
            background-color: var(--dark) !important;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
            color: var(--white) !important;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: var(--primary) !important;
        }
    </style>
@endpush
@push('js')
    <script defer src="{{mix('js/app.js')}}"></script>
    <livewire:modals/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts/>
    <x-livewire-alert::flash/>
    <x-modals::scripts/>
@endpush
