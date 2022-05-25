<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

@if (!empty($type) && $type == 'alert-danger')
    <div class="component-alert-danger">
        {{ $text }}        
    </div>
    @if (!empty($smallText))
        <small>{{ $smallText }}</small>
    @endif
@endif

@if (!empty($type) && $type == 'alert-warning')
    <div class="component-alert-warning">
        {{ $text }}        
    </div>
    @if (!empty($smallText))
        <small>{{ $smallText }}</small>
    @endif
@endif

@if (!empty($type) && $type == 'alert-info')
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        {{ $text }}        
    </div>
    @if (!empty($smallText))
        <small>{{ $smallText }}</small>
    @endif
@endif

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session()->get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session()->get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      {{ session()->get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif