@extends('adminlte::components.form.input-group-component')

@section('input_group_item')

    {{-- Select --}}
    <x-form::select id="{{ $id }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => $makeItemClass()]) }}>
        {{ $slot }}
    </x-form::select>

@overwrite

{{-- Support to auto select the old submitted values --}}

@if($errors->any() && $enableOldSupport)
    @push('js')
        <script>

            $(() => {

                let oldOptions = @json(collect($getOldValue($errorKey)));

                $('#{{ $id }} option').each(function () {
                    let value = $(this).val() || $(this).text();
                    $(this).prop('selected', oldOptions.includes(value));
                });
            });

        </script>
    @endpush
@endif
