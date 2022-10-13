@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-5">
                <div class="row g-2">
                    <div class="col-lg-3 col-6">
                        {{-- Themes --}}
                        <x-adminlte-small-box title="{{$waiting}}" text="En attente" icon="fas fa-inbox"
                                              theme="danger" url="{{$box_url}}"
                                              url-text="View details"/>
                    </div>

                    <div class="col-lg-3 col-6">
                        {{-- Themes --}}
                        <x-adminlte-small-box title="{{$ongoing}}" text="En cours" icon="fas fa-eye"
                                              theme="success" url="{{$box_url}}" url-text="View details"/>
                    </div>

                    <div class="col-lg-3 col-6">
                        {{-- Themes --}}
                        <x-adminlte-small-box title="{{$issued}}" text="Traitées" icon="fas fa-check"
                                              theme="primary" url="{{$box_url}}"
                                              url-text="View details"/>
                    </div>

                    <div class="col-lg-3 col-6">
                        {{-- Themes --}}
                        <x-adminlte-small-box title="{{$rejected}}" text="Rejetées" icon="fas fa-times"
                                              theme="warning" url="{{$box_url}}"
                                              url-text="View details"/>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
