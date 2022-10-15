@extends('adminlte::page')
@section('content')
    {{-- Minimal with title, text and icon --}}

    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('companies.edit',Auth::user()->company)}}">
            <x-adminlte-info-box title="{{ auth()->user()->company->name }}" text="Entreprise" icon="fas fa-lg fa-store"
                                 icon-theme="purple"/>
        </a>
    </div>
@endsection
