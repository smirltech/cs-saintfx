@php use App\Enums\RolePermission;use App\Enums\Permission\UserPermission;use App\Enums\UserRole; @endphp
@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex align-items-center flex-column">
                                <div class="sw-13 position-relative mb-3">
                                    <x-avatar-edit :model="$user"/>
                                </div>
                                <div class="h5 mb-0">{{$user->name}}@if ($user->hasVerifiedEmail())
                                        <i class="fa fa-check-circle"></i>
                                    @endif</div>
                                <div class="text-muted">{{$user->role_name??'N/A'}}
                                </div>
                                <div class="text-muted">
                                    <i class="zmdi zmdi-email"></i>
                                    <span class="align-middle">{{ $user->email }}</span>

                                </div>
                                <div class="mt-3">
                                    @if(Gate::allows('users.create') AND auth()->user()->id != $user->id)
                                        <form method="post" class="center"
                                              action="{{route('users.destroy',$user)}}">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-5 tab-content">
                <div class="tab-pane fade show active" id="overviewTab" role="tabpanel">
                    <div class="card mb-5">
                        <div class="card-body">
                            @if(Gate::allows('users.create') || auth()->user()->id == $user->id)
                                <form action="{{route('users.update',$user)}}" enctype="multipart/form-data"
                                      method="POST"
                                      class="form-horizontal">
                                    @csrf @method('PUT')

                                    <div class="form-group row">
                                        <label for="name"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input placeholder="" id="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror" name="name"
                                                   value="{{$user->name}}" required autocomplete="name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                                    }}</label>

                                        <div class="col-md-6">
                                            <input readonly placeholder="" id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email"
                                                   value="{{$user->email}}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @can('users.create')
                                        <div class="form-group row">
                                            <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('Role')
                                    }}</label>

                                            <div class="col-md-6">
                                                <select name="role_id" id="role_id"
                                                        class="form-control  form-select">
                                                    @foreach ($roles as $role)
                                                        <option
                                                                value="{{$role->id}}">{{$role->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endcan
                                    @if ($user->hasVerifiedEmail())
                                        <div class="form-group row">
                                            <label for="role_id" class="col-md-4 col-form-label text-md-right"></label>

                                            <div class="col-md-6">
                                                <a href="{{ route('users.password.autoreset',$user) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fa fa-key"></i> {{ __('Reset Password') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif


                                    <hr hidden>
                                    <div class="card-footer">

                                        <a href="{{route('users.index')}}" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                        @can('users.create')
                                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                                <i class="fa fa-save"></i> {{__('Save')}}
                                            </button>
                                        @endcan
                                    </div>

                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
