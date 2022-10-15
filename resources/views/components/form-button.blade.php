@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'btn btn-primary']) !!}>
    {{ $slot }}
    <span wire:loading wire.target="submit">
                            <i class="fa fa-spinner"></i>
                        </span>
</button>
