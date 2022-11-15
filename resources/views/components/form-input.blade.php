@props(['disabled' => false,'isValid','label','error'])
@php
    if (isset($isValid )) {
        $classes = ($isValid ===true)
                    ? ' is-valid'
                    : ' is-invalid';
    } else {
        $classes = '';
    }
@endphp
@if(isset($label))
    <label class="form-label">{{$label}}</label>
@endif
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control'.$classes]) !!}>
@if(isset($error))
    <x-form-invalid-feedback>
        {{$error}}
    </x-form-invalid-feedback>
@endif


