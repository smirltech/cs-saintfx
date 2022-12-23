@props(['disabled' => false,'isValid','label','error','placeholder'])
@php
    if (isset($isValid )) {
        $classes = ($isValid ===true)
                    ? ' is-valid'
                    : ' is-invalid';
    } else {
        $classes = '';
    }
@endphp
@include('components.form-label')
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control'.$classes]) !!}>
    <option disabled value="">{{$placeholder??'-- Sélectionner --'}}</option>
    {{$slot}}
</select>
@if(isset($error))
    <x-form-invalid-feedback>
        {{$error}}
    </x-form-invalid-feedback>
@endif



