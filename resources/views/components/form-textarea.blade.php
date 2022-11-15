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
<div>
    @if(isset($label))
        <label class="form-label">{{$label}}</label>
    @endif
    <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control'.$classes]) !!}>
        {{$slot}}
    </textarea>
    @if(isset($error))
        <x-form-invalid-feedback>
            {{$error}}
        </x-form-invalid-feedback>
    @endif
</div>



