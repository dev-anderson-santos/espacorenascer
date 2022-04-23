<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

@if ($type == 'alert-danger')
    <div class="component-alert-danger">
        {{ $text }}
    </div>
@endif