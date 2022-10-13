@props(['disabled' => false,'label'])

@if(isset($label))
    <label class="form-label">{{$label}}</label>
@endif

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control form-select']) !!}>
    {{$slot}}
</select>

