@section('content_header')
    <h1 class="m-0 text-dark">Presence
@stop
{!! $calendar_view !!}
@push('js_top')
    {!! $calendar_script !!}
@endpush
