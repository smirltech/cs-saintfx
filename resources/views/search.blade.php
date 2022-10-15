@extends('adminlte::page')
@section('content_header')
    <h4>
        <i class="fas fa-search"></i> {{__('Recherche')}}
    </h4>
@endsection

@section('content')
    <div class="p-0 container-fluid mt-3">
        @section('content')
            <div class="p-0 container-fluid mt-3">
                <livewire:search-mention :demandes="$demandes" :matricule="$matricule"/>
            </div>
        @endsection
    </div>
@endsection
