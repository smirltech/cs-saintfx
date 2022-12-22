@if(isset($label))
    <label class="form-label">{{$label}}
        @if($attributes->has('required'))
            <span class="text-danger">*</span>
        @endif
    </label>
@endif

